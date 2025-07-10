<?php

namespace backend\controllers;

use common\components\StaticFunctions;
use common\models\GalleryItems;
use common\models\Pages;
use common\models\PageSections;
use common\models\PageSectionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * PageSectionsController implements the CRUD actions for PageSections model.
 */
class PageSectionsController extends Controller
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
     * Lists all PageSections models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PageSectionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PageSections model.
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
     * Creates a new PageSections model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $model = new PageSections();
        $pages = Pages::find()
            ->select(['name', 'id'])
            ->indexBy('id')
            ->column();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $image = UploadedFile::getInstance($model, 'image');
                $images = UploadedFile::getInstances($model, 'galleryImages');

                if ($image) {
                    $model->image = StaticFunctions::uploadFile($image, 'page-sections', $model->id);
                }

                if($images){
                    foreach ($images as $item){
                        $section_image = new GalleryItems();
                        $section_image->section_id= $model->id;
                        $section_image->image = StaticFunctions::uploadFile($item,'page-sections', $model->id);
                        $section_image->save();
                    }
                }

                $translations = Yii::$app->request->post('PageSectionTranslations', []);
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
            'pages' => $pages,
        ]);
    }

    /**
     * Updates an existing PageSections model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = PageSections::find()->with('translations')->where(['id' => $id])->one();
        $pages = Pages::find()
            ->select(['name', 'id'])
            ->indexBy('id')
            ->column();
        $oldImage = $model->image;

        if ($this->request->isPost && $model->load($this->request->post())) {

            $translations = Yii::$app->request->post('PageSectionTranslations', []);

            if ($model->save()) {
                $model->saveTranslations($translations);
                $image = UploadedFile::getInstance($model, 'image');
                if ($image) {
                    $newImage = StaticFunctions::uploadFile($image, 'page-sections', $model->id);
                    if ($newImage) {
                        if (!empty($oldImage)) {
                            StaticFunctions::deleteImage($oldImage, 'page-sections', $model->id);
                        }
                        $model->image = $newImage;
                    }
                } else {
                    $model->image = $oldImage;
                }

                $images = UploadedFile::getInstances($model, 'galleryImages');

                if($images){
                    foreach ($images as $item){
                        $section_image = new GalleryItems();
                        $section_image->section_id= $model->id;
                        $section_image->image = StaticFunctions::uploadFile($item,'page-sections', $model->id);
                        $section_image->save();
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
            'pages' => $pages,
        ]);
    }


    public function actionDeleteImage($id)
    {
        $model = $this->findModel($id);

        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'page-sections', $model->id);
            $model->image = null;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    public function actionDeleteGalleryImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $key = Yii::$app->request->post('key');

        $image = GalleryItems::findOne($key);

        if (!$image) {
            return ['success' => false, 'error' => 'Изображение не найдено'];
        }
        StaticFunctions::deleteImage($image->image, 'page-sections', $image->section_id);

        $image->delete();

        return ['success' => true];
    }


    /**
     * Deletes an existing PageSections model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Удаление основного изображения
        if (!empty($model->image)) {
            StaticFunctions::deleteImage($model->image, 'page-sections', $model->id);
        }

        // Удаление изображений галереи
        $galleryItems = GalleryItems::find()->where(['section_id' => $model->id])->all();

        foreach ($galleryItems as $item) {
            StaticFunctions::deleteImage($item->image, 'page-sections', $model->id);
            $item->delete();
        }

        // Удаление самой модели
        $model->delete();

        Yii::$app->session->setFlash('success', 'Успешно удалено!');
        return $this->redirect(['index']);
    }
    /**
     * Finds the PageSections model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PageSections the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PageSections::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
