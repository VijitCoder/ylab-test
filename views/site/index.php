<?php
/**
 * @var $this         yii\web\View
 * @var $searchModel  app\models\ProductSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Products summary table';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php Pjax::begin(); ?>

    <div class="form-group form-inline pull-right">
        <label>Group by</label>
        <?= Html::dropDownList(
                'groupBy',
                'provider',
                ['provider' => 'providers', 'category' => 'categories'],
                ['class' => 'form-control',]
            ); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [
                'attribute' => 'id',
                'options'   => ['width' => '70px',],
            ],
            'title',
            [
                'attribute' => 'price',
                'options'   => ['width' => '100px',],
            ],
            'category.title',
            'provider.title',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
