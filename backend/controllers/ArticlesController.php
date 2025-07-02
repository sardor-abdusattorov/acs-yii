<?php

namespace backend\controllers;

use common\components\StaticFunctions;
use common\models\Articles;
use common\models\ArticlesSearch;
use common\models\ArticlesTranslations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends Controller
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
     * Lists all Articles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticlesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Articles model.
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
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Articles();

        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $translations = Yii::$app->request->post('ArticlesTranslations', []);
                $title = $translations['en']['title'] ?? null;

                if (empty($model->slug) && $title) {
                    $model->slug = Articles::slugify($title);
                } else {
                    $model->slug = Articles::slugify($model->slug);
                }

                if ($model->save()) {
                    $model->saveTranslations($translations);

                    $image = UploadedFile::getInstance($model, 'image');

                    if ($image) {
                        $filename = StaticFunctions::uploadFile($image, 'articles', $model->id);
                        if ($filename) {
                            $model->image = $filename;

                            $filePath = StaticFunctions::getFolder('articles', $model->id) . $filename;
                            StaticFunctions::saveThumbnail($filePath, 'articles', $model->id, $filename, 550, 370);

                            $model->save(false);
                        }
                    }

                    Yii::$app->session->setFlash('success', 'Успешно добавлено!');
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
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = $model->image;
        if ($this->request->isPost && $model->load($this->request->post())) {

            $translations = Yii::$app->request->post('ArticlesTranslations', []);
            $title = $translations['en']['title'] ?? null;

            if (empty($model->slug) && $title) {
                $model->slug = Articles::slugify($title);
            } else {
                $model->slug = Articles::slugify($model->slug);
            }

            if ($model->save()) {
                $model->saveTranslations($translations);
                $image = UploadedFile::getInstance($model, 'image');

                if ($image) {
                    $newImage = StaticFunctions::uploadFile($image, 'articles', $model->id);
                    if ($newImage) {
                        if (!empty($oldImage)) {
                            StaticFunctions::deleteImage($oldImage, 'articles', $model->id);
                        }
                        $model->image = $newImage;
                        $path = StaticFunctions::getFolder('articles', $model->id) . $newImage;
                        StaticFunctions::saveThumbnail($path, 'articles', $model->id, $newImage, 550, 370);
                    }
                } else {
                    $model->image = $oldImage;
                }

                $model->save(false);

                Yii::$app->session->setFlash('success', 'Успешно обновлено!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDeleteImage($id)
    {
        $model = $this->findModel($id);

        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'articles', $model->id);
            $model->image = null;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    /**
     * Deletes an existing Articles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'articles', $model->id);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Успешно удалено!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
