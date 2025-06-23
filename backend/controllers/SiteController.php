<?php

namespace backend\controllers;

use common\components\ActivityLogger;
use Yii;
use yii\base\InvalidArgumentException;

use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'captcha', 'request-password-reset'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
//            'captcha' => [
//                'class' => CaptchaAction::class,
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Yii::$app->user->identity;
            Yii::$app->session->setFlash('success', 'Добро пожаловать, ' . $user->full_name . '!');

            return $this->goHome();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Вы успешно вышли из системы.');

        return $this->goHome();
    }

}