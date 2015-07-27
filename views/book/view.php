<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/**
 * @var yii\web\View        $this
 * @var app\models\Book     $book
 * @var app\models\Author   $author
 */

$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">
    <?= DetailView::widget([
        'model' => $book,
        'attributes' => [
            'id',
            'name',
            [
                'label'  => 'Превью',
                'format' => 'raw',
                'value'  => ( ! empty($book->image))
                    ? Html::a(Html::img(Url::toRoute(['book/thumb', 'id' => $book->id])), '#', [
                        'id' => 'bookThumb',
                        'class' => 'preview',
                        'data-image-url' => Url::toRoute(['book/image', 'id' => $book->id])
                    ])
                    : 'No photo',
            ],
            [
                'attribute' => 'date',
                'format'    => ['date', 'php:d.m.Y'],
            ],
            [
                'attribute' => 'date_create',
                'format'    => ['date', 'php:d.m.Y h:i:s'],
            ],
            [
                'attribute' => 'date_update',
                'format'    => ['date', 'php:d.m.Y h:i:s'],
            ],
            [
                'attribute' => 'author_id',
                'label' => 'Автор',
                'value' => $author->getFullName()
            ],
        ],
    ]) ?>

</div>
