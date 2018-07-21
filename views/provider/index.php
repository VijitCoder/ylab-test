<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProviderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Providers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <p><?= Html::a('Create Provider', ['create'], ['class' => 'btn btn-success']) ?></p>

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
            [
                'attribute' => 'sequence',
                'options'   => ['width' => '70px',],
            ],
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
