<?php

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '创建商品';
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create col-sm-12">
	<div class=" ibox ibox-content" style="margin-top: 15px;">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
