<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
/**
 * @var Ambigous <boolean, \yii\db\TableSchema> $tableSchema
 */
$tableSchema = $generator->getTableSchema();
echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
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
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();
<?php 
    $placeholder = '';

?>
<?php foreach ($generator->getColumnNames() as $attribute){
    $comments = $tableSchema->columns[$attribute]->comment;
    if ($comments) {
        $arr = explode($generator->dilimiter, $comments);
        $type = $arr[1] ?? false;
        if ($type) {
            switch ($type) {
                case in_array($type, $generator->imageFlag);//单图
                $placeholder .= <<<STR
                
            \$post = \Yii::\$app->getRequest()->post(\$model->formName());
            \$model->$attribute = \$post['$attribute'][0] ?? '';
STR;
            }
        }
    }
}?>
<?php 
$str = <<<STR
        if (\$model->load(Yii::\$app->request->post())) { $placeholder
            if(\$model->save()) {
                return \$this->redirect(['index']);
            }
        } else {
            return \$this->render('create', [
                'model' => \$model,
            ]);
        }
STR;
?>
<?=$str?>

    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

<?php 
    $placeholder = '';

?>
<?php foreach ($generator->getColumnNames() as $attribute){
    $comments = $tableSchema->columns[$attribute]->comment;
    if ($comments) {
        $arr = explode($generator->dilimiter, $comments);
        $type = $arr[1] ?? false;
        if ($type) {
            switch ($type) {
                case in_array($type, $generator->imageFlag);//单图
                $placeholder .= <<<STR
                
            \$post = \Yii::\$app->getRequest()->post(\$model->formName());
            \$model->$attribute = \$post['$attribute'][0] ?? '';
STR;
            }
        }
    }
}?>
<?php 
$str = <<<STR
        if (\$model->load(Yii::\$app->request->post())) { $placeholder
            if(\$model->save()) {
                return \$this->redirect(['index']);
            }
        } else {
            return \$this->render('update', [
                'model' => \$model,
            ]);
        }
STR;
?>
<?=$str?>
	
	}

<?php foreach ($generator->getColumnNames() as $attribute){
    $str = '';
    $comments = $tableSchema->columns[$attribute]->comment;
    if ($comments) {
        $arr = explode($generator->dilimiter, $comments);
        $type = $arr[1] ?? false;
        if ($type) {
            $action = ucfirst($attribute);
            switch ($type) {
                case in_array($type, $generator->sortFlag);
                $str .= <<<STR
    /**
     * update $attribute of an existing $modelClass  model
     * @param int \$id
     * @return mixed
     */
    public function action$action(\$id)
    {
        \Yii::\$app->getResponse()->format = 'json';
        \$moodel = \$this->findModel(\$id);
        \$moodel->$attribute = \Yii::\$app->getRequest()->post('value');
        return \$moodel->save() ? \$moodel : current(\$moodel->getFirstErrors());
    }
STR;
            }
        }
        if ($str) {
            echo $str;
        }
    }
}?>


    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
