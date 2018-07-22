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
