<?php
namespace app\controllers;

use app\models\Provider;
use app\models\ProviderSearch;
use yii\db\ActiveRecord;

/**
 * ProviderController implements the CRUD actions for Provider model.
 */
class ProviderController extends CRUDController
{
    /**
     * Get Provider model
     *
     * @return ActiveRecord
     */
    protected function getModel(): ActiveRecord
    {
        return new Provider;
    }

    /**
     * Get Provider search model
     *
     * @return ActiveRecord
     */
    protected function getSearchModel(): ActiveRecord
    {
        return new ProviderSearch;
    }
}
