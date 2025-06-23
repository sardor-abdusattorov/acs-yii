<?php

namespace mdm\admin\controllers;
use common\components\StaticFunctions;
use mdm\admin\components\UserStatus;
use mdm\admin\models\form\ChangePassword;
use mdm\admin\models\form\Login;
use mdm\admin\models\form\PasswordResetRequest;
use mdm\admin\models\form\ResetPassword;
use mdm\admin\models\form\Signup;
use mdm\admin\models\form\Update;
use mdm\admin\models\searchs\User as UserSearch;
use mdm\admin\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\mail\BaseMailer;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * User controller
 */
class UserController extends Controller
{
    private $_oldMailPath;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'logout' => ['post'],
                    'activate' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->has('mailer') && ($mailer = Yii::$app->getMailer()) instanceof BaseMailer) {
                /* @var $mailer BaseMailer */
                $this->_oldMailPath = $mailer->getViewPath();
                $mailer->setViewPath('@mdm/admin/mail');
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->_oldMailPath !== null) {
            Yii::$app->getMailer()->setViewPath($this->_oldMailPath);
        }
        return parent::afterAction($action, $result);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        $image = $user->avatar;

        if ($user->delete()) {
            if ($image) {
                StaticFunctions::deleteImage($image, 'user', $user->id);
            }

            Yii::$app->session->setFlash('success', 'Успешно удалено!');
            return $this->redirect(['index']);
        }
        Yii::$app->session->setFlash('error', 'Ошибка при удалении пользователя.');
        return $this->redirect(['index']);
    }




    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }
        $model = new Update($id);
        $oldImage = $user->avatar;
        if ($this->request->isPost && $model->load($this->request->post())) {
            $image = UploadedFile::getInstance($model, 'avatar');
            if (empty($oldImage)) {
                if ($image) {
                    $model->avatar = StaticFunctions::uploadFile($image, 'user', $model->id);
                }
            } else {
                if ($image) {
                    $model->avatar = StaticFunctions::uploadFile($image, 'user', $model->id);
                    StaticFunctions::deleteImage($oldImage, 'user', $model->id);
                } else {
                    $model->avatar = $oldImage;
                }
            }

            if ($model->update()) {
                Yii::$app->session->setFlash('success', 'Успешно обновлено!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка обновления данных');
                var_dump($model->errors);
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }


    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                    'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                $image = UploadedFile::getInstance($model, 'avatar');
                if ($image) {
                    $user->avatar = StaticFunctions::uploadFile($image, 'user', $user->id);
                    $user->save(false);
                }
                return $this->redirect(['/rbac/']);
            }
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }


    /**
     * Request reset password
     * @return string
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequest();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                'model' => $model,
        ]);
    }

    /**
     * Reset password
     * @return string
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                'model' => $model,
        ]);
    }

    /**
     * Reset password
     * @return string
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
            return $this->goHome();
        }

        return $this->render('change-password', [
                'model' => $model,
        ]);
    }

    /**
     * Activate new user
     * @param integer $id
     * @return type
     * @throws UserException
     * @throws NotFoundHttpException
     */
    public function actionActivate($id)
    {
        /* @var $user User */
        $user = $this->findModel($id);
        if ($user->status == UserStatus::INACTIVE) {
            $user->status = UserStatus::ACTIVE;
            if ($user->save()) {
                return $this->goHome();
            } else {
                $errors = $user->firstErrors;
                throw new UserException(reset($errors));
            }
        }
        return $this->goHome();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
