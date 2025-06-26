<?php

namespace backend\controllers;

use common\models\Message;
use common\models\SourceMessage;
use common\models\SourceMessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;

/**
 * SourceMessageController implements the CRUD actions for SourceMessage model.
 */
class SourceMessageController extends Controller
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
     * Lists all SourceMessage models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->orderBy(['id' => SORT_DESC]);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SourceMessage model.
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
     * Creates a new SourceMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SourceMessage();
        $languages = array_keys(Yii::$app->params['languages']);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->category = 'app';
            if ($model->save()) {
                $postTranslations = Yii::$app->request->post("Message");

                foreach ($languages as $lang) {
                    $translation = Message::findOne(['id' => $model->id, 'language' => $lang]) ?? new Message();
                    $translation->id = $model->id;
                    $translation->language = $lang;
                    $translation->translation = $postTranslations[$lang]['translation'] ?? '';
                    $translation->save();
                }

                Yii::$app->session->setFlash('success', 'Успешно добавлено!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing SourceMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $languages = array_keys(Yii::$app->params['languages']);
        $postTranslations = Yii::$app->request->post("Message");

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            foreach ($languages as $lang) {
                $translation = Message::findOne(['id' => $model->id, 'language' => $lang]);
                if (empty($postTranslations[$lang]['translation'])) {
                    if ($translation) {
                        $translation->delete();
                    }
                    continue;
                }
                if (!$translation) {
                    $translation = new Message();
                    $translation->id = $model->id;
                    $translation->language = $lang;
                }
                $translation->translation = $postTranslations[$lang]['translation'];
                $translation->save();
            }

            Yii::$app->session->setFlash('success', 'Успешно обновлено!');
            return $this->redirect(['index']);
        }
        $translations = $model->getMessages()->indexBy('language')->all();
        return $this->render('update', [
            'model' => $model,
            'translations' => $translations,
        ]);
    }

    /**
     * Deletes an existing SourceMessage model.
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
     * Finds the SourceMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SourceMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SourceMessage::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
