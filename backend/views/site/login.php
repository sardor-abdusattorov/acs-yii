<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Login';
?>

<div class="auth-fluid" style="background-image: url('<?= Yii::getAlias('@web') ?>/dist/img/bg-auth.jpg')">
    <div class="auth-fluid-form-box" >

    <div class="align-items-center d-flex h-100">
            <div class="p-3 w-100">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <div class="auth-logo">
                        <div class="logo text-center">
                            <span class="logo-lg">
                               <img src="<?=Yii::getAlias('@web') ?>/dist/img/logo.png" alt="logo" style="max-width: 250px">
                            </span>
                        </div>
                    </div>
                </div>

                <!-- title-->
                <h4 class="mt-0">Авторизация</h4>
                <p class="text-muted mb-4">Для входа заполните поля:</p>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>


                <?= $form->field($model, 'username', [
                    'options' => [
                        'tag' => 'div',
                        'class' => 'input-group mb-3 has-feedback'
                    ],
                    'template' => '{input}<div class="input-group-append">
                                        <div class="input-group-text">
                                          <span class="fas fa-user"></span>
                                        </div>
                                      </div>
                                      {error}{hint}'
                ])->input('text', [
                    'placeholder' => 'Имя пользователя',
                    'autofocus' => true,
                ])->label(false) ?>

                <?= $form->field($model, 'password', [
                    'options' => [
                        'tag' => 'div',
                        'class' => 'input-group mb-3 has-feedback'
                    ],
                    'template' => '{input}<div class="input-group-append">
                                        <div class="input-group-text">
                                          <span class="fas fa-lock"></span>
                                        </div>
                                      </div>
                                      {error}{hint}'
                ])->passwordInput()->input('password',
                    [
                        'placeholder' => 'Пароль',
                    ])->label(false) ?>


                <div class="row">
                    <div class="col-12">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>


                <div class="form-group mt-3">
                    <?= Html::a('Перейти на сайт', Yii::$app->params['frontend'], ['class' => 'btn btn-secondary btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
