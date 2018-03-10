<?php
namespace console\controllers;

use common\models\AccountLog;
use common\models\ChargeLog;
use common\models\ConsumeLog;
use yii\console\Controller;
//刷新用户消费日志
class ConsumeController extends Controller
{
    protected $server;

    const WORK_NUM = 8;
    const TASK_NUM = 8;



    public function actionIndex()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $this->server = new \swoole_server('127.0.0.1', '9502');
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
        //告诉worker线程 处理完毕
        $model                  = new ConsumeLog();
        $model->user_account_id = $uid;
        $model->m_12            = $this->getConsumeAmountByMount($uid, 12);//12月消费金额
        $model->m_1             = $this->getConsumeAmountByMount($uid, 1);//1月消费金额
        $model->m_2             = $this->getConsumeAmountByMount($uid, 2);//2月消费金额
        $model->m_3             = $this->getConsumeAmountByMount($uid, 3);//3月消费金额
        $model->m_4             = $this->getConsumeAmountByMount($uid, 4);//4月消费金额
        $model->save(false);



        AccountLog::updateAll(['flag' => 0],['account_log_account_id' => $uid]);
        return $uid . '   finish' . PHP_EOL;
    }


    /**
     * @param     $uid
     * @param int $mount
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getConsumeAmountByMount($uid, $mount = 12)
    {
        $date = self::getDate($mount);

        //用户本月抽奖所得金额
        $winGold = AccountLog::find()
            ->where(['account_log_account_id' => $uid])
            ->andWhere([
                'between',
                'account_log_create_at',
                $date[0],
                $date[1]
            ])->andWhere(['account_log_desc' => '抽奖所得'])
            ->sum('account_log_amount');
        //用户本月被赠送的
        $freeGold = AccountLog::find()
            ->where(['account_log_account_id' => $uid])
            ->andWhere([
                'between',
                'account_log_create_at',
                $date[0],
                $date[1]
            ])->andWhere(['account_log_desc' => ['每天首次登录送100金豆', '首次登录送1000金豆']])
            ->sum('account_log_amount');
        //本月输掉的
        $loseGold = AccountLog::find()
            ->where(['account_log_account_id' => $uid])
            ->andWhere([
                'between',
                'account_log_create_at',
                $date[0],
                $date[1]
            ])->andWhere(['account_log_desc' => '抽奖扣豆'])
            ->sum('account_log_amount');

        return $loseGold - $winGold - $freeGold;
    }


    /**
     * @param $mount
     *
     * @return array
     * @throws \Exception
     */
    public static function getDate($mount)
    {
        if ($mount == 12) {
            return [
                '2017-12-01',
                '2018-01-01'
            ];
        }
        if ($mount == 1) {
            return [
                '2018-01-01',
                '2018-02-01'
            ];
        }
        if ($mount == 2) {
            return [
                '2018-02-01',
                '2018-03-01'
            ];
        }
        if ($mount == 3) {
            return [
                '2018-03-01',
                '2018-04-01'
            ];
        }
        if ($mount == 4) {
            return [
                '2018-03-01',
                '2018-04-01'
            ];
        }

        throw new \Exception('无效的数据');
    }

}