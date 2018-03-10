<?php
namespace console\controllers;

use common\models\AccountLog;
use common\models\ChargeLog;
use common\models\ConsumeLog;
use common\models\DetailLog;
use yii\console\Controller;

//计算用户消费有价值和清零
class CoreController extends Controller
{
    protected $server;

    const WORK_NUM = 20;
    const TASK_NUM = 20;

    public function actionIndex()
    {
        //初始化数据
        \Yii::$app->db->createCommand('UPDATE `charge_log` SET `balance`= amount')->execute();
        ChargeLog::updateAll(['flag' => 0]);
        \Yii::$app->db->close();
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $this->server = new \swoole_server('127.0.0.1', '9503');
        $this->server->set([
            'worker_num'      => self::WORK_NUM,
            'task_worker_num' => self::TASK_NUM,
        ]);
        $this->server->on("Receive", [$this, 'onReceive']);
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on("Finish", [$this, 'onFinish']);
        $this->server->start();
    }

    public function onFinish($serv, $task_id, $data)
    {
        echo $data;
    }

    /**
     * 添加任务
     *
     * @param $ser
     * @param $fd
     * @param $from_id
     * @param $data
     *
     * @throws \Exception
     * @internal param $uid
     */
    public function onReceive($ser, $fd, $from_id, $action)
    {
        //投递任务
        foreach (IndexController::getIds() as $id) {
            $this->server->task($id);
        }
        $ser->send($fd, '投递任务成功');
    }

    public function onTask($serv, $task_id, $from_id, $uid)
    {
        self::begin($uid, 12);
        self::begin($uid, 1);
        self::begin($uid, 2);
        self::begin($uid, 3);
        self::begin($uid, 4);

        return $uid . '   finish' . PHP_EOL;
    }

    public static function begin($uid, $mount)
    {
        //得到用户充值记录
        $list = ChargeLog::find()->Where(['user_account_id' => $uid])->all();
        //获取用户待处理的消费金额
        $userGoldConsumeLog = ConsumeLog::findOne(['user_account_id' => $uid]);
        $amount             = $userGoldConsumeLog->{'m_' . $mount};

        //消费的有价值的金额 默认等于消费的金额
        $realAmount = 0;

        //计算用户有价值消费金额
        //第一步处理上一个月消费金豆为负数情况,即上个月的赠送未消费完
        if ($mount == 1) {
            $attr_last_month = 'm_12';
        } else {
            $attr_last_month = 'm_' . ($mount - 1);
        }
        $userGoldConsumeLog_last_month = ConsumeLog::findOne(['user_account_id' => $uid]);
        $amount_last_month             = $userGoldConsumeLog_last_month->$attr_last_month ?? 0;
        if ($amount_last_month < 0) {
            $amount += $amount_last_month;//优先去除上月未消费的赠送金豆
        }
        //第二步处理用户充值记录
        if ($amount > 0) {
            $realAmount = $amount;
            $i          = 0;
            foreach ($list as $item) {
                $i++;
                if ($item->flag == 2) {
                    //如果记录被处理掉了 就跳过
                    continue;
                }
                $f = $amount;
                //对当前充值记录进行处理
                $amount = $amount - $item->balance;
                //充值余额大于消费金额
                if ($amount < 0) {
                    $item->balance = -$amount;
                    $item->flag    = 1;//该条记录还有充值余额
                    $item->save(false);
                    $amount = 0;
                    self::saveDetail($item,$f,$mount);

                    break;
                }

                //充值余额小于消费金额
                self::saveDetail($item,$item->balance,$mount);

                $item->balance = 0;
                $item->flag    = 2;//该条记录已处理完
                $item->save(false);
            }

            //正常情况下$amount = 0,如果$amount>0 那么证明没有更多可以处理的记录了 那么真实消费记录就累减
            $realAmount = $realAmount - $amount;
        }

        //第三步处理清0
        $systemAmount = 0;
        foreach ($list as $item) {
            //开始计算人民币
            $type = $item->type == 1 ? 1 : ($item->amount == 150000 ? 2 : 3);
            //该条记录未处理 或者有余额
            if ($item->flag == 1 || $item->flag == 0) {
                $itemTime = date('m', strtotime($item->created_at));
                if ($mount == 1 && $itemTime == 12) {
                    self::saveDetail($item,$item->balance,$mount);
                    $systemAmount  += $item->balance;
                    $item->flag    = 2;
                    $item->balance = 0;
                    $item->save(false);
                } else {
                    if ($itemTime == $mount - 1) {
                        self::saveDetail($item,$item->balance,$mount);

                        $systemAmount  += $item->balance;
                        $item->flag    = 2;
                        $item->balance = 0;
                        $item->save(false);

                    }
                }
            }
        }
        $userGoldConsumeLog->{'real_' . $mount . '_rmb'}   = $realAmount;
        $userGoldConsumeLog->{'system_' . $mount . '_rmb'} = $systemAmount;
        $userGoldConsumeLog->save(false);
    }

    public static function saveDetail(ChargeLog $log,$amount,$mount){
        $model = new DetailLog();
        $model->user_account_id = $log->user_account_id;
        $model->amount = $amount;//有价值的或者清零的金豆数
        $model->account_amount = $log->amount;
        $model->type = self::goldType($log->amount);
        //拨备金金额
        $bbj = $model->type == 0 ? 0 : ($model->type == 1 ? 100 : 160);
        $model->rmb = (($model->account_amount/1000 - $bbj) / $model->account_amount)*$model->amount;
        $model->mount = $mount;
        $model->save(false);
    }

    /**
     * 获取金豆类型  普通=>0 150豆=>1 其他2
     * @param int $amount
     *
     * @return int
     */
    protected static function goldType(int $amount)
    {
        $isGrant = 150000 <= $amount && $amount <= 300000;
        if ($isGrant) {
            return $amount == 150000 ? 1 : 2;
        }else{
            return 0;
        }
    }
}