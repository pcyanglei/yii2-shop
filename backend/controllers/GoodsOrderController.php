<?php

namespace backend\controllers;

use backend\models\Goods;
use common\components\cart\GoodsOrderService;
use common\models\GoodsOrderSnapshot;
use common\models\User;
use Yii;
use common\models\GoodsOrder;
use backend\models\GoodsOrder as GoodsOrderSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * GoodsOrderController implements the CRUD actions for GoodsOrder model.
 */
class GoodsOrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all GoodsOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GoodsOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionCreate()
    {
        $goods = $this->findGoodsModel();
        /* @var  $goodsOrderService GoodsOrderService*/
        $goodsOrderService = \Yii::$app->order;
        foreach ($goods as $good) {
            $goodsOrderService->put($good,1);
        }
        $order = new GoodsOrder();
        $order->sn = time();
        $order->total_price = $goodsOrderService->getCost();
        $order->user_id = 1;

        $orderSnapshot = new GoodsOrderSnapshot();
        $transaciton = $order->getDb()->beginTransaction();
        try{
            if ($order->save(false) !== true) {
                throw new Exception('save goodsOrder fail');
            }
            $orderSnapshot->goods_order_id = $order->id;
            if ($orderSnapshot->save(false) !== true){
                throw new Exception('save goodsOrderSnapshot fail');
            }
            $transaciton->commit();
            return $this->redirect(['index']);
        }catch (Exception $e) {
            $transaciton->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Updates an existing GoodsOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) { 
            if($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }	
	}

    /**
     * @return GoodsOrder[]
     * @throws NotFoundHttpException
     */
	public function actionAllOrder():array
    {
        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $user = $this->getUserModel(1);
        return $user->goodsOrders;//$user->getGoodsOrders()->all()
    }

    /**
     * @param $id
     * @return User
     * @throws NotFoundHttpException
     */
    protected function getUserModel($id):User
    {
        if (($model = User::findOne($id)) !== null && $model->id == User::ACTIVE_STATU) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Deletes an existing GoodsOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GoodsOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodsOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 模拟数据
     */
    protected function findGoodsModel()
    {
        return Goods::findAll(['id' => [1,2,3]]);
    }
}
