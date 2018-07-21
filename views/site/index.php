<?php
/**
 * @var $this         yii\web\View
 * @var $searchModel  app\models\ProductSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Products summary table';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php Pjax::begin(); ?>

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
