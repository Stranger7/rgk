<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View            $this
 * @var app\models\Book         $book
 * @var app\models\UploadForm   $model
 */

$this->title = 'Загрузить картинку для : ' . ' ' . $book->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upload';
?>
<div class="book-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="book-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <input type="hidden" name="id" value="<?= $book->id ?>">
            <?= $form->field($model, 'imageFile')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
