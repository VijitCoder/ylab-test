<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form
        ->field($model, 'category_id')->dropDownList(
            $categories,
            [
                'prompt'           => 'Select category...',
                'class'            => 'selectpicker',
                'data-live-search' => 'true',
                'data-size'        => 12,
            ]
        )
        ->label('Category');
    ?>

    <?= $form
        ->field($model, 'provider_id')->dropDownList(
            $providers,
            [
                'prompt'           => 'Select provider...',
                'class'            => 'selectpicker',
                'data-live-search' => 'true',
                'data-size'        => 12,
            ]
        )
        ->label('Provider');
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
