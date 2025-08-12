<?php

namespace backend\controllers;

use common\models\Subscribers;
use common\models\SubscribersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;

/**
 * SubscribersController implements the CRUD actions for Subscribers model.
 */
class SubscribersController extends Controller
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
     * Lists all Subscribers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SubscribersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subscribers model.
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
     * Finds the Subscribers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Subscribers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscribers::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
