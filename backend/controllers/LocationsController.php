<?php

namespace backend\controllers;

use common\components\StaticFunctions;
use common\models\GalleryItems;
use common\models\LocationImages;
use common\models\Locations;
use common\models\LocationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * LocationsController implements the CRUD actions for Locations model.
 */
class LocationsController extends Controller
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
     * Lists all Locations models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LocationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Locations model.
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
     * Creates a new Locations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Locations();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $translations = Yii::$app->request->post('LocationTranslation', []);
                $images = UploadedFile::getInstances($model, 'galleryImages');
                $model->saveTranslations($translations);

                $image = UploadedFile::getInstance($model, 'image');

                if ($image) {
                    $model->image = StaticFunctions::uploadFile($image, 'locations', $model->id);
                }

                if($images){
                    foreach ($images as $item){
                        $section_image = new LocationImages();
                        $section_image->location_id= $model->id;
                        $section_image->image = StaticFunctions::uploadFile($item,'locations', $model->id);
                        $section_image->save();
                    }
                }

                Yii::$app->session->setFlash('success','Успешно добавлено!');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDeleteGalleryImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $key = Yii::$app->request->post('key');

        $image = LocationImages::findOne($key);

        if (!$image) {
            return ['success' => false, 'error' => 'Изображение не найдено'];
        }
        StaticFunctions::deleteImage($image->image, 'locations', $image->location_id);

        $image->delete();

        return ['success' => true];
    }

    /**
     * Updates an existing Locations model.
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

            $translations = Yii::$app->request->post('LocationTranslation', []);
            $model->saveTranslations($translations);

            if ($model->save()) {
                $model->saveTranslations($translations);
                $image = UploadedFile::getInstance($model, 'image');

                $images = UploadedFile::getInstances($model, 'galleryImages');

                if ($image) {
                    $newImage = StaticFunctions::uploadFile($image, 'locations', $model->id);
                    if ($newImage) {
                        if (!empty($oldImage)) {
                            StaticFunctions::deleteImage($oldImage, 'locations', $model->id);
                        }
                        $model->image = $newImage;
                    }
                } else {
                    $model->image = $oldImage;
                }


                if($images){
                    foreach ($images as $item){
                        $location_image = new LocationImages();
                        $location_image->location_id= $model->id;
                        $location_image->image = StaticFunctions::uploadFile($item,'locations', $model->id);
                        $location_image->save();
                    }
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

    public function actionDeleteImage($id)
    {
        $model = $this->findModel($id);

        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'locations', $model->id);
            $model->image = null;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    /**
     * Deletes an existing Locations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $galleryItems = LocationImages::find()->where(['location_id' => $model->id])->all();

        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'locations', $model->id);
        }

        foreach ($galleryItems as $item) {
            StaticFunctions::deleteImage($item->image, 'locations', $model->id);
            $item->delete();
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Успешно удалено!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Locations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Locations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Locations::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
