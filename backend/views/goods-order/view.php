<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>

</style>

<div class="goods-order-view  wrapper wrapper-content animated fadeInRigh">
	<div class="ibox-content col-sm-8 col-sm-offset-2 page">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <table style="text-align:left" class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align:center" colspan="3"><h1>详情查看</h1></th>
            </tr>
        </thead>
        <tbody>
        	<tr><td>id</td><td><?=Html::encode($model->id);?></td></tr>
        	<tr><td>序号</td><td><?=Html::encode($model->sn);?></td></tr>
        	<tr><td>总价</td><td><?=Html::encode($model->total_price);?></td></tr>
        	<tr><td>user_id</td><td><?=Html::encode($model->user_id);?></td></tr>
        </tbody>
    </table>
	</div>
</div>
