<?php

namespace backend\controllers;

use common\models\Organisations;
use common\models\Vacancy;
use common\models\VacancyInformation;
use common\models\VacancySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;

/**
 * VacancyController implements the CRUD actions for Vacancy model.
 */
class VacancyController extends Controller
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
     * Lists all Vacancy models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VacancySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vacancy model.
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
     * Creates a new Vacancy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $model = new Vacancy();
        $modelsInformation = [new VacancyInformation];
        $organisations = Organisations::find()->where(['status' => 1])->all();

        if ($this->request->isPost && $model->load($this->request->post())) {

            $translations = Yii::$app->request->post('VacancyTranslations', []);
            $title = $translations['en']['title'] ?? null;

            $informations = Yii::$app->request->post('VacancyInformationTranslations', []);

            if (empty($model->slug) && $title) {
                $model->slug = Organisations::slugify($title);
            } else {
                $model->slug = Organisations::slugify($model->slug);
            }

            if ($model->save()) {
                $model->saveTranslations($translations);
                $model->saveInformations($informations);

                Yii::$app->session->setFlash('success', 'Успешно добавлено!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'organisations' => $organisations,
            'modelsInformation' => $modelsInformation,
        ]);
    }

    /**
     * Updates an existing Vacancy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Vacancy::find()->with(['translations', 'informations.translations'])->where(['id' => $id])->one();
        if (!$model) {
            throw new NotFoundHttpException('Вакансия не найдена.');
        }

        $modelsInformation = $model->informations;
        $organisations = Organisations::find()->where(['status' => 1])->all();

        if ($this->request->isPost && $model->load($this->request->post())) {

            $translations = Yii::$app->request->post('VacancyTranslations', []);
            $informations = Yii::$app->request->post('VacancyInformationTranslations', []);
            $title = $translations['en']['title'] ?? null;

            if (empty($model->slug) && $title) {
                $model->slug = Vacancy::slugify($title);
            } else {
                $model->slug = Vacancy::slugify($model->slug);
            }

            if ($model->save()) {
                $model->saveTranslations($translations);
                $model->saveInformations($informations);

                Yii::$app->session->setFlash('success', 'Успешно обновлено!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'organisations' => $organisations,
            'modelsInformation' => $modelsInformation,
        ]);
    }


    /**
     * Deletes an existing Vacancy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('success','Успешно удалено!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Vacancy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Vacancy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vacancy::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
