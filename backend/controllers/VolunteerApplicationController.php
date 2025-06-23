<?php

namespace backend\controllers;

use common\models\VolunteerApplication;
use common\models\VolunteerApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;

/**
 * VolunteerApplicationController implements the CRUD actions for VolunteerApplication model.
 */
class VolunteerApplicationController extends Controller
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
     * Lists all VolunteerApplication models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VolunteerApplicationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VolunteerApplication model.
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
     * Finds the VolunteerApplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return VolunteerApplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VolunteerApplication::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
