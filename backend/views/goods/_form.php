<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin([
    	'options' => ['class' => 'form-horizontal'],
    	'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'template' => "{label}\n<div class=\"col-sm-8\">{input}\n<span class=\"help-block m-b-none\">{error}</span></div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
    	]
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
    	<div class="col-sm-4 col-sm-offset-2">
        	<?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    	</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
