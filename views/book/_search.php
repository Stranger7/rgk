<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View            $this
 * @var yii\widgets\ActiveForm  $form
 * @var app\models\BookSearch   $model
 * @var array                   $authors
 */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'id' => 'filter-form',
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            Фильтр
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'name') ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'date_start')->textInput(['type' => 'date']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'date_end')->textInput(['type' => 'date']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'author_id')->dropDownList($authors, ['prompt'=>'Select...']) ?>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton('Фильтр', ['class' => 'btn btn-primary']) ?>
            <?= Html::button('Сброс', ['class' => 'btn btn-default reset']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>