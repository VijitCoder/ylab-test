<?php
namespace app\controllers;

use yii\base\InvalidArgumentException;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\ContactForm;

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
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
