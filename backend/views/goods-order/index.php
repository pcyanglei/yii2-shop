<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GoodsOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="goods-order-index col-sm-12" style="margin-top: 15px;">
    <p>
        <?= Html::a('创建订单', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<div class="ibox ibox-content">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'sn',
            'total_price',
            'user_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'headerOptions' => ['width'=>'150px'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a('查看', $url,['class' =>'btn btn-outline btn-default btn-xs']);
                    },
                    'update' => function($url, $model, $key){
                    	return Html::a('修改', $url,['class' =>'btn btn-outline btn-info btn-xs']);
                   	},
                    'delete' => function($url, $model, $key){
                       	return Html::a('删除', $url,['data-confirm' => '你确定要删除吗?','data-method' => 'POST','class' =>'btn btn-outline btn-danger btn-xs']);
                   	},
               ],
            ],
        ],
    ]); ?>
	</div>
</div>