<?php

namespace backend\controllers;

use common\components\StaticFunctions;
use common\models\Organisations;
use common\models\OrganisationsSearch;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * OrganisationsController implements the CRUD actions for Organisations model.
 */
class OrganisationsController extends Controller
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
     * Lists all Organisations models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrganisationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organisations model.
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
     * Creates a new Organisations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Organisations();

        if ($this->request->isPost) {
            $translations = Yii::$app->request->post('OrganisationTranslations', []);
            $title = $translations['en']['title'] ?? null;

            if ($model->load($this->request->post())) {

                if (empty($model->slug) && $title) {
                    $model->slug = Organisations::slugify($title);
                } else {
                    $model->slug = Organisations::slugify($model->slug);
                }

                if ($model->save()) {
                    $model->saveTranslations($translations);

                    $image = UploadedFile::getInstance($model, 'image');
                    $preview = UploadedFile::getInstance($model, 'preview_image');

                    if ($preview) {
                        $filename = StaticFunctions::uploadFile($preview, 'organisations', $model->id);
                        if ($filename) {
                            $model->preview_image = $filename;

                            $file_name = StaticFunctions::getFolder('organisations', $model->id) . $filename;
                            StaticFunctions::saveThumbnail($file_name, 'organisations', $model->id, $filename, 300, 200);
                        }
                    }

                    if ($image) {
                        $model->image = StaticFunctions::uploadFile($image, 'organisations', $model->id);
                    }

                    $model->save(false);

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
     * Updates an existing Organisations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = $model->image;
        $oldPreview = $model->preview_image;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $translations = Yii::$app->request->post('OrganisationTranslations', []);
            $title = $translations['en']['title'] ?? null;

            if (empty($model->slug) && $title) {
                $model->slug = Organisations::slugify($title);
            } else {
                $model->slug = Organisations::slugify($model->slug);
            }

            if ($model->save()) {
                $model->saveTranslations($translations);
                $image = UploadedFile::getInstance($model, 'image');
                if ($image) {
                    $newImage = StaticFunctions::uploadFile($image, 'organisations', $model->id);
                    if ($newImage) {
                        if (!empty($oldImage)) {
                            StaticFunctions::deleteImage($oldImage, 'organisations', $model->id);
                        }
                        $model->image = $newImage;
                    }
                } else {
                    $model->image = $oldImage;
                }
                $preview = UploadedFile::getInstance($model, 'preview_image');
                if ($preview) {
                    $newPreview = StaticFunctions::uploadFile($preview, 'organisations', $model->id);
                    if ($newPreview) {
                        if (!empty($oldPreview)) {
                            StaticFunctions::deleteImage($oldPreview, 'organisations', $model->id);
                        }
                        $model->preview_image = $newPreview;
                        $path = StaticFunctions::getFolder('organisations', $model->id) . $newPreview;
                        StaticFunctions::saveThumbnail($path, 'organisations', $model->id, $newPreview);
                    }
                } else {
                    $model->preview_image = $oldPreview;
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
            StaticFunctions::deleteImage($model->image, 'organisations', $model->id);
            $model->image = null;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }


    public function actionDeletePreview($id)
    {
        $model = $this->findModel($id);

        if ($model->preview_image) {
            StaticFunctions::deleteImage($model->preview_image, 'organisations', $model->id);
            $model->preview_image = null;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    /**
     * Deletes an existing Organisations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'organisations', $model->id);
        }

        if ($model->preview_image) {
            StaticFunctions::deleteImage($model->preview_image, 'organisations', $model->id);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Успешно удалено!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Organisations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Organisations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organisations::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
