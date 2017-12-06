<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '创建用户';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create col-sm-12">
	<div class=" ibox ibox-content" style="margin-top: 15px;">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
