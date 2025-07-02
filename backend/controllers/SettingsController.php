<?php

namespace backend\controllers;

use common\components\StaticFunctions;
use common\models\Settings;
use common\models\SettingsSearch;
use common\models\SettingTranslations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
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
     * Lists all Settings models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Settings model.
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
     * Creates a new Settings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Settings();

        if ($this->request->isPost) {
            $translations = Yii::$app->request->post('SettingTranslations', []);

            if ($model->load($this->request->post())) {

                if ($model->save()) {
                    $model->saveTranslations($translations);

                    $image = UploadedFile::getInstance($model, 'image');

                    if ($image) {
                        $model->image = StaticFunctions::uploadFile($image, 'settings', $model->id);
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
     * Updates an existing Settings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Settings::find()->with('translations')->where(['id' => $id])->one();
        $oldImage = $model->image;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $translations = Yii::$app->request->post('SettingTranslations', []);

            if ($model->save()) {
                if (!$model->is_translatable) {
                    SettingTranslations::deleteAll(['setting_id' => $model->id]);

                } else {
                    $model->value = null;
                    $model->saveTranslations($translations);
                }

                $image = UploadedFile::getInstance($model, 'image');
                if ($image) {
                    $newImage = StaticFunctions::uploadFile($image, 'settings', $model->id);
                    if ($newImage) {
                        if (!empty($oldImage)) {
                            StaticFunctions::deleteImage($oldImage, 'settings', $model->id);
                        }
                        $model->image = $newImage;
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
            StaticFunctions::deleteImage($model->image, 'settings', $model->id);
            $model->image = null;
            $model->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    /**
     * Deletes an existing Settings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->image) {
            StaticFunctions::deleteImage($model->image, 'settings', $model->id);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Успешно удалено!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
