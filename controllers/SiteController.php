<?php
namespace app\controllers;

use app\models\ProductSearch;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\UnknownMethodException;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Main controller of the project
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return ['error' => ['class' => ErrorAction::class]];
    }

    /**
     * Displays homepage.
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
