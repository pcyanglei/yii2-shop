<?php
namespace console\controllers;

use common\models\DetailLog;
use common\models\TotalLog;
use yii\console\Controller;

/**
 * Created by PhpStorm.
 * User: yanglei
 * Date: 2018/3/10
 * Time: 下午7:05
 */
class TotalController extends Controller
{
    public function actionIndex()
    {
        $ids = IndexController::getIds();
        foreach ($ids as $id) {
            $model                  = new TotalLog();
            $model->user_account_id = $id;
            $model->total_12        = DetailLog::find()
                    ->where(['user_account_id' => $id, 'mount' => 12])
                    ->sum('rmb') ?? 0;
            $model->total_1         = DetailLog::find()
                    ->where(['user_account_id' => $id, 'mount' => 1])
                    ->sum('rmb') ?? 0;
            $model->total_2         = DetailLog::find()
                    ->where(['user_account_id' => $id, 'mount' => 2])
                    ->sum('rmb') ?? 0;
            $model->total_3         = DetailLog::find()
                    ->where(['user_account_id' => $id, 'mount' => 3])
                    ->sum('rmb') ?? 0;
            $model->total_4         = DetailLog::find()
                    ->where(['user_account_id' => $id, 'mount' => 4])
                    ->sum('rmb') ?? 0;
            $model->save(false);
            echo $id.'|';
        }

    }
}