<?php

use yii\helpers\Html;

/**
 * @var yii\web\View        $this
 * @var app\models\Book     $model
 * @var array               $authors
 */

$this->title = 'Update Book: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>

</div>
