<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-search search-wrap">

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

    <?= $form->field($model, 'name') ->textInput(['placeholder'=>'请输入商品名字'])?>

    <?= $form->field($model, 'price') ->textInput(['placeholder'=>'请输入价格'])?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<hr />
