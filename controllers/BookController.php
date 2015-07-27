<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use app\models\Author;
use app\models\BookSearch;
use app\models\Book;
use app\models\UploadForm;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        // save filter, sort order, page number in session
        Url::remember();

        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'authors' => ArrayHelper::map(Author::find()->all(), 'id', function(Author $author) {
                return $author->firstname . ' ' . $author->lastname;
            })
        ]);
    }

    /**
     * Show thumbnail of book image
     *
     * @param int $id
     * @throws NotFoundHttpException
     */
    public function actionThumb($id)
    {
        $model   = $this->findModel($id);
        $imagine = new Imagine();
        $size    = new Box(40, 40);
        $mode    = ImageInterface::THUMBNAIL_INSET;
        $imagine->open(UploadForm::UPLOAD_PATH . $model->image)->thumbnail($size, $mode)->show('jpg');
    }

    /**
     * Show book image
     *
     * @param int $id
     * @throws NotFoundHttpException
     */
    public function actionImage($id)
    {
        $model   = $this->findModel($id);
        $imagine = new Imagine();
        $size    = new Box(850, 850);
        $mode    = ImageInterface::THUMBNAIL_INSET;
        $imagine->open(UploadForm::UPLOAD_PATH . $model->image)->thumbnail($size, $mode)->show('jpg');
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $book = $this->findModel($id);
        return $this->renderAjax('view', [
            'book' => $book,
            'author' => Author::findOne($book->author_id)
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous());
        }
        return $this->render('create', [
            'model' => $model,
            'authors' => ArrayHelper::map(Author::find()->all(), 'id', function(Author $author) {
                return $author->firstname . ' ' . $author->lastname;
            })
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return $this->render('update', [
                'model' => $model,
                'authors' => ArrayHelper::map(Author::find()->all(), 'id', function(Author $author) {
                    return $author->firstname . ' ' . $author->lastname;
                }),
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        @unlink(UploadForm::UPLOAD_PATH . $model->image);
        return $this->redirect(['index']);
    }

    /**
     * Render form for image uploading and upload image.
     *
     * @param string $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpload($id)
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $book = $this->findModel(Yii::$app->request->post('id'));
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($filename = $model->upload()) {
                // remove old image
                if ( ! empty($book->image)) {
                    @unlink(UploadForm::UPLOAD_PATH . $book->image);
                }
                // save image filename
                $book->image = $filename;
                if ($book->save()) {
                    return $this->redirect(Url::previous());
                }
            }
        }

        return $this->render('upload_image', [
            'book' => $this->findModel($id),
            'model' => $model,
        ]);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
