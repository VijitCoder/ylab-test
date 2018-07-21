<?php
namespace app\controllers;

use app\models\Category;
use app\models\CategorySearch;
use yii\db\ActiveRecord;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends CRUDController
{
    /**
     * Get Category model
     *
     * @return ActiveRecord
     */
    protected function getModel(): ActiveRecord
    {
        return new Category;
    }

    /**
     * Get category search model
     *
     * @return ActiveRecord
     */
    protected function getSearchModel(): ActiveRecord
    {
        return new CategorySearch;
    }
}
