<?php

use common\components\Editor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProgramSessions $model */
/** @var yii\bootstrap5\ActiveForm $form */

$languages = Yii::$app->params['languages'];
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-body">

                <ul class="nav nav-tabs mb-3" role="tablist">
                    <?php foreach ($languages as $code => $label): ?>
                        <li class="nav-item">
                            <button class="nav-link <?= $code === Yii::$app->language ? 'active' : '' ?>"
                                    data-bs-toggle="tab"
                                    data-bs-target="#lang-<?= $code ?>" type="button">
                                <?= Html::encode($label) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content mb-4">
                    <?php foreach ($languages as $code => $label): ?>
                        <div class="tab-pane fade <?= $code === Yii::$app->language ? 'show active' : '' ?>"
                             id="lang-<?= $code ?>" role="tabpanel">
                            <?= $form->field($model->translate($code), "[$code]title")
                                ->textInput(['maxlength' => true, 'placeholder' => "Заголовок на {$label}"])
                                ->label("Заголовок ({$label})") ?>

                            <?= $form->field($model->translate($code), "[$code]content")->widget(Editor::class, [
                                'options' => [
                                    'useKrajeePresets' => true,
                                    'placeholder' => "Контент на {$label}",
                                ]
                            ])->label("Контент ({$label})") ?>

                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'date_id')->dropDownList(
                    ArrayHelper::map($dates, 'id', 'date'),
                    ['prompt' => 'Выберите дату']
                ) ?>

                <?= $form->field($model, 'sort')->textInput() ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
