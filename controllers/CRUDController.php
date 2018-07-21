<?php
namespace app\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\UnknownMethodException;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Base CRUD controller, implements the CRUD actions for any model.
 */
abstract class CRUDController extends Controller
{
    /**
     * Get entity model
     *
     * @return ActiveRecord
     */
    abstract protected function getModel(): ActiveRecord;

    /**
     * Get search entity model
     *
     * @return ActiveRecord
     */
    abstract protected function getSearchModel(): ActiveRecord;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all entity models.
     *
     * @return mixed
     * @throws InvalidArgumentException
     * @throws UnknownMethodException
     */
    public function actionIndex()
    {
        $searchModel = $this->getSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single entity model.
     *
     * @param integer $id
     * @return mixed
     * @throws InvalidArgumentException
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new entity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function actionCreate()
    {
        $model = $this->getModel();
        return $this->renewEntity($model, 'create');
    }

    /**
     * Updates an existing entity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     * @throws InvalidArgumentException
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->renewEntity($model, 'update');
    }

    /**
     * Update or create new entity model.
     *
     * @param ActiveRecord $model
     * @param string       $view update|create
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function renewEntity(ActiveRecord $model, string $view)
    {
        $data = Yii::$app->request->post();

        if ($model->load($data) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render($view, ['model' => $model]);
    }

    /**
     * Deletes an existing entity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the entity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): ActiveRecord
    {
        $model = $this->getModel()->findOne($id);
        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
