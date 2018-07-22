<?php
/**
 * @var $this         yii\web\View
 * @var $searchModel  app\models\ProductSummarySearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use app\models\ProductSummarySearch;
use app\widgets\SpanDataColumn;
use app\widgets\SpanGridView;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

$this->title = 'Products summary table';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <div class="category-search">

        <?php $form = ActiveForm::begin([
            'action'  => ['/'],
            'method'  => 'get',
            'options' => [
                'data-pjax' => 1,
            ],
        ]); ?>

        <div class="form-group form-inline pull-right">
            <label>Group by</label>
            <?= Html::dropDownList(
                'groupBy',
                $searchModel->groupBy,
                [
                    ProductSummarySearch::GRP_BY_PROVIDER => 'providers',
                    ProductSummarySearch::GRP_BY_CATEGORY => 'categories',
                ],
                ['class' => 'form-control', 'onchange' => 'this.form.submit()']
            ); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?= SpanGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [
                'attribute' => 'id',
                'options'   => ['width' => '70px',],
            ],
            [
                'attribute' => 'title',
                'format'    => 'raw',
                'value'     => function ($data) {
                    return Html::a(
                        $data->title, 
                        ['product/update', 'id' => $data->id], 
                        ['title' => 'Edit product', 'class' => 'no-pjax']
                    );
                },
            ],
            [
                'attribute' => 'price',
                'options'   => ['width' => '100px',],
            ],
            [
                'attribute' => 'category.title',
                'format'    => 'raw',
                'value'     => function ($data) {
                    return Html::a(
                        $data->category->title, 
                        ['category/update', 'id' => $data->category->id], 
                        ['title' => 'Edit category', 'class' => 'no-pjax']
                    );
                },
            ],
            [
                'attribute' => 'provider.title',
                'format'    => 'raw',
                'value'     => function ($data) {
                    return Html::a(
                        $data->provider->title, 
                        ['provider/update', 'id' => $data->provider->id], 
                        ['title' => 'Edit provider', 'class' => 'no-pjax']
                    );
                },
            ],
        ],
    ]); ?>
    
    <?php Pjax::end(); ?>
    
</div>
