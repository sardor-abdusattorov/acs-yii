<?php

namespace backend\controllers;

use common\components\FileUpload;
use common\components\StaticFunctions;
use common\models\Books;
use common\models\BooksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
        );
    }

    /**
     * Lists all Books models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Books model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Books();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $translations = Yii::$app->request->post('BooksTranslations', []);
                $image = UploadedFile::getInstance($model, 'image');
                $file = UploadedFile::getInstance($model, 'file');

                if ($image) {
                    $model->image = StaticFunctions::uploadFile($image, 'books', $model->id);
                }

                if ($file) {
                    $model->file = FileUpload::uploadFile($file, 'books', $model->id);
                }

                $model->saveTranslations($translations);

                if($model->save()){
                    Yii::$app->session->setFlash('success','Успешно добавлено!');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = $model->image;
        $oldFile = $model->file;

        if ($this->request->isPost && $model->load($this->request->post())) {

            $translations = Yii::$app->request->post('BooksTranslations', []);

            if ($model->save()) {
                $model->saveTranslations($translations);
                $image = UploadedFile::getInstance($model, 'image');
                $file = UploadedFile::getInstance($model, 'file');

                if ($image) {
                    $newImage = StaticFunctions::uploadFile($image, 'books', $model->id);
                    if ($newImage) {
                        if (!empty($oldImage)) {
                            StaticFunctions::deleteImage($oldImage, 'books', $model->id);
                        }
                        $model->image = $newImage;
                    }
                } else {
                    $model->image = $oldImage;
                }

                if ($file) {
                    $newFile = FileUpload::uploadFile($file, 'books', $model->id);
                    if ($newFile) {
                        if (!empty($oldFile)) {
                            FileUpload::deleteFile($oldFile, 'books', $model->id);
                        }
                        $model->file = $newFile;
                    }
                } else {
                    $model->file = $oldFile;
                }

                $model->save(false);

                Yii::$app->session->setFlash('success', 'Успешно обновлено!');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $model->loadDefaultValues();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDeleteFile($id)
    {
        $model = $this->findModel($id);

        if ($model->file) {
            FileUpload::deleteFile($model->file, 'books', $model->id);
            $model->file = null;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    public function actionDeleteImage($id)
    {
        $model = $this->findModel($id);

        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'books', $model->id);
            $model->image = null;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);


        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'books', $model->id);
        }

        if ($model->file) {
            FileUpload::deleteFile($model->video_url, 'books', $model->id);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Успешно удалено!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
