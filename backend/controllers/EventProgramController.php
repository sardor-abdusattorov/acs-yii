<?php

namespace backend\controllers;

use common\models\EventProgram;
use common\models\EventProgramSearch;
use common\models\Locations;
use common\models\Tags;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;

/**
 * EventProgramController implements the CRUD actions for EventProgram model.
 */
class EventProgramController extends Controller
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
     * Lists all EventProgram models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EventProgramSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EventProgram model.
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
     * Creates a new EventProgram model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new EventProgram();
        $locations = Locations::getDropdownList();
        $tags = Tags::getDropdownList();

        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && $model->save()) {
                $translations = Yii::$app->request->post('EventProgramTranslation', []);

                $model->saveTranslations($translations);

                \Yii::$app->session->setFlash('success','Успешно добавлено!');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'locations' => $locations,
            'tags' => $tags,
        ]);
    }

    /**
     * Updates an existing EventProgram model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $locations = Locations::getDropdownList();
        $tags = Tags::getDropdownList();

        if ($this->request->isPost && $model->load($this->request->post())) {

            $translations = Yii::$app->request->post('EventProgramTranslation', []);

            if ($model->save()) {
                $model->saveTranslations($translations);

                $model->save(false);

                Yii::$app->session->setFlash('success', 'Успешно обновлено!');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $model->loadDefaultValues();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'locations' => $locations,
            'tags' => $tags,
        ]);
    }

    /**
     * Deletes an existing EventProgram model.
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
     * Finds the EventProgram model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return EventProgram the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventProgram::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
