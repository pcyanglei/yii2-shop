<?php
namespace console\controllers;

use common\helpers\ClientHelper;
use common\models\AccountLog;
use common\models\ChargeLog;
use common\models\Goods;
use yii\console\Controller;
use yii\db\Exception;

class IndexController extends Controller
{
    protected $server;

    const WORK_NUM = 8;
    const TASK_NUM = 8;

    public static function getIds()
    {
        return AccountLog::find()
            ->select(['account_log_account_id'])
            ->asArray()
//            ->limit(20)
            ->groupBy('account_log_account_id')
            ->column();
    }

    public function actionIndex()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $this->server = new \swoole_server('127.0.0.1', '9501');
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
        foreach (self::getIds() as $id) {
            $this->server->task($id);
        }
        $ser->send($fd, '投递任务成功');
    }

    public function onTask($serv, $task_id, $from_id, $uid)
    {
        //告诉worker线程 处理完毕

        //查询每一个用户在当月全部的充值记录
        $charges = AccountLog::find()
            ->where(['account_log_account_id' => $uid])
            ->andWhere(['account_log_desc' => '充值金豆'])
            ->asArray()
            ->all();
        foreach ($charges as $charge) {
            $m                  = new ChargeLog();
            $m->created_at      = $charge['account_log_create_at'];
            $m->amount          = $charge['account_log_amount'];
            $m->user_account_id = $charge['account_log_account_id'];
            $m->save(false);
        }
        AccountLog::updateAll(['flag' => 1],['account_log_account_id' => $uid]);
        return $uid . '   finish' . PHP_EOL;
    }
}