<?php

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <p><?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => SerialColumn::class],
            [
                'attribute' => 'id',
                'options'   => ['width' => '70px',],
            ],
            'title',
            'description:ntext',
            'price',
            //'image',
            'created_at',
            'updated_at',
            [
                'class'   => ActionColumn::class,
                'options' => ['width' => '70px',],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
