<?php

namespace backend\controllers;

use common\models\Faq;
use common\models\FaqSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;

/**
 * FaqController implements the CRUD actions for Faq model.
 */
class FaqController extends Controller
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
     * Lists all Faq models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FaqSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Faq model.
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
     * Creates a new Faq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Faq();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $translations = Yii::$app->request->post('FaqTranslations', []);
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
     * Updates an existing Faq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Faq::find()->with('translations')->where(['id' => $id])->one();

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {

            $translations = Yii::$app->request->post('FaqTranslations', []);
            $model->saveTranslations($translations);

            if($model->save()){
                \Yii::$app->session->setFlash('success','Успешно обновлено!');
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Faq model.
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
     * Finds the Faq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Faq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faq::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
