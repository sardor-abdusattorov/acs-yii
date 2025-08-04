<?php

namespace backend\controllers;

use common\models\ProgramDate;
use common\models\ProgramSessions;
use common\models\ProgramSessionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;

/**
 * ProgramSessionsController implements the CRUD actions for ProgramSessions model.
 */
class ProgramSessionsController extends Controller
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
     * Lists all ProgramSessions models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProgramSessionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProgramSessions model.
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
     * Creates a new ProgramSessions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProgramSessions();

        $dates = ProgramDate::find()
            ->orderBy(['date' => SORT_ASC])
            ->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $translations = Yii::$app->request->post('ProgramSessionsTranslation', []);

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
            'dates' => $dates,
        ]);
    }

    /**
     * Updates an existing ProgramSessions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dates = ProgramDate::find()
            ->orderBy(['date' => SORT_ASC])
            ->all();


        if ($this->request->isPost && $model->load($this->request->post())) {
            $translations = Yii::$app->request->post('ProgramSessionsTranslation', []);

            $model->saveTranslations($translations);

            if($model->save()){
                \Yii::$app->session->setFlash('success','Успешно обновлено!');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $model->loadDefaultValues();
            }

        }

        return $this->render('update', [
            'model' => $model,
            'dates' => $dates,
        ]);
    }

    /**
     * Deletes an existing ProgramSessions model.
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
     * Finds the ProgramSessions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProgramSessions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProgramSessions::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
