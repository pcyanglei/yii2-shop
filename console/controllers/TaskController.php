<?php
namespace console\controllers;

use common\helpers\ClientHelper;
use common\models\AccountLog;
use yii\console\Controller;

/**
 * Created by PhpStorm.
 * User: yang lei
 * Date: 2018/3/10
 * Time: 上午10:42
 */
class TaskController extends Controller
{

//    public function init()
//    {
//        ini_set('memory_limit', '1024M');
//        set_time_limit(0);
//    }



    //刷新用户充值日志
    public function actionChargeLog()
    {
        (new ClientHelper())->call('chargeLog');
    }
    //刷新用户消费
    public function actionConsume()
    {
        (new ClientHelper(9502))->call('11');
    }

    public function actionCore()
    {
        (new ClientHelper(9503))->call('11');
    }
}