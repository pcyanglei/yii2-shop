<?php

/* @var $this yii\web\View */
/* @var $model common\models\GoodsOrder */
$this->title = '修改订单';
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>

<div class="goods-order-update col-sm-12">
	<div class=" ibox ibox-content" style="margin-top: 15px;">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>