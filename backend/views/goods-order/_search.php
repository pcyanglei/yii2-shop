<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-order-search search-wrap">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline'],
        'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'template' => "{input}"
        ],
    ]); ?>

    <?= $form->field($model, 'id') ->textInput(['placeholder'=>'请输入id'])?>

    <?= $form->field($model, 'sn') ->textInput(['placeholder'=>'请输入序号'])?>

    <?= $form->field($model, 'total_price') ->textInput(['placeholder'=>'请输入总价'])?>

    <?= $form->field($model, 'user_id') ->textInput(['placeholder'=>'请输入user_id'])?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<hr />
