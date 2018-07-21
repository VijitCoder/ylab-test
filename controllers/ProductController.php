<?php
namespace app\controllers;

use app\models\Product;
use app\models\ProductSearch;
use yii\db\ActiveRecord;

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
}
