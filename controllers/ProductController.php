<?php
namespace app\controllers;

use app\models\Category;
use app\models\Product;
use app\models\ProductSearch;
use app\models\Provider;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends CRUDController
{
    /**
     * Get Product model
     *
     * @return ActiveRecord
     */
    protected function getModel(): ActiveRecord
    {
        return new Product;
    }

    /**
     * Get Product search model
     *
     * @return ActiveRecord
     */
    protected function getSearchModel(): ActiveRecord
    {
        return new ProductSearch;
    }

    /**
     * Update or create new product model.
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

        $data = Category::find()->all();
        $categories = ArrayHelper::map($data, 'id', 'title');
        
        $data = Provider::find()->all();
        $providers = ArrayHelper::map($data, 'id', 'title');
        
        return $this->render($view, compact('model', 'categories', 'providers'));
    }
}
