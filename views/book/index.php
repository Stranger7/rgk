<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\web\JqueryAsset;

/**
 * @var yii\web\View                $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\BookSearch       $searchModel
 * @var array                       $authors
 */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', [
        'model' => $searchModel,
        'authors' => $authors
    ]); ?>

    <p>
        <?= Html::a('Создать запись', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'label'  => 'Превью',
                'format' => 'raw',
                'value'  => function($data) {
                    if ( ! empty($data['image'])) {
                        $val = Html::a(
                            Html::img(Url::toRoute(['book/thumb', 'id' => $data['id']])), '#', [
                                'class' => 'preview',
                                'data-image-url' => Url::toRoute(['book/image', 'id' => $data['id']])
                            ]
                        );
                    } else {
                        $val = 'No photo';
                    }
                    $val .= '&nbsp;'
                        . Html::a('<span class="glyphicon glyphicon-upload"></span>',
                            Url::toRoute(['book/upload', 'id' => $data['id']]),
                            [
                                'class' => 'upload-image',
                                'title' => 'Загрузка изображения'
                            ]
                        );
                    return $val;
                }
            ],
            [
                'attribute' => 'full_name',
                'label' => 'Автор',
                'content' => function($data) {
                    /** @var \app\models\Author $author */
                    $author = $data['author'];
                    return $author->getFullName();
                }
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
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                            'class' => 'book-view',
                            'title' => 'Просмотр',
                            'data-view-url' => $url
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php
    Modal::begin([
        'id' => 'bookViewModal',
        'header' => '<h3>Инфо</h3>',
        'size' => 'modal-lg',
    ]);
    echo '<div id="bookInfo"></div>';
    Modal::end();
    ?>

    <?php
    Modal::begin([
        'id' => 'bookImageModal',
        'header' => '<h3>Изображение</h3>',
        'size' => 'modal-lg',
    ]);
    echo '<div id="bookImage" style="text-align: center"></div>';
    Modal::end();
    ?>

</div>
<?php
$this->registerJsFile(Yii::getAlias('@web/js/book.js'), ['depends' => JqueryAsset::className()]);
?>
