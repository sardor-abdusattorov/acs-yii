<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Pages $model */
/** @var yii\bootstrap5\ActiveForm $form */

$languages = Yii::$app->params['languages'];
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

                <ul class="nav nav-tabs mb-3" role="tablist">
                    <?php foreach ($languages as $code => $name): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $code === Yii::$app->language ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#lang-<?= $code ?>" type="button">
                                <?= Html::encode($name) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content">
                    <?php foreach ($languages as $code => $name): ?>
                        <div class="tab-pane fade <?= $code === Yii::$app->language ? 'show active' : '' ?>" id="lang-<?= $code ?>" role="tabpanel">
                            <?= $form->field($model->translate($code), "[$code]title")->textInput([
                                'maxlength' => true,
                                'placeholder' => "Заголовок на {$name}"
                            ])->label("Заголовок ({$name})") ?>

                            <?= $form->field($model->translate($code), "[$code]meta_title")->textInput([
                                'maxlength' => true,
                                'placeholder' => "Meta title на {$name}"
                            ])->label("Meta title ({$name})") ?>

                            <?= $form->field($model->translate($code), "[$code]meta_description")->textarea([
                                'rows' => 3,
                                'placeholder' => "Meta description на {$name}"
                            ])->label("Meta description ({$name})") ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
