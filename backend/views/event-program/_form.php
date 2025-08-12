<?php

use common\components\Editor;
use kartik\select2\Select2;
use kartik\widgets\ColorInput;
use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;
use kartik\widgets\TimePicker;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EventProgram $model */
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

                            <?= $form->field($model->translate($code), "[$code]description")->widget(Editor::class, [
                                'options' => [
                                    'useKrajeePresets' => true,
                                    'placeholder' => "Подзаголовок на {$label}"
                                ]
                            ])->label("Подзаголовок ({$label})") ?>


                            <?= $form->field($model->translate($code), "[$code]content")->widget(Editor::class, [
                                'options' => [
                                    'useKrajeePresets' => true,
                                    'placeholder' => "Контент на {$label}",
                                ]
                            ])->label("Контент ({$label})") ?>

                        </div>
                    <?php endforeach; ?>
                </div>

                <?= $form->field($model, 'day')->widget(DatePicker::class, [
                    'options' => ['placeholder' => 'Выберите дату'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                    ],
                ]) ?>

                <?= $form->field($model, 'start_time')->widget(TimePicker::class, [
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'minuteStep' => 5,
                    ],
                ]) ?>

                <?= $form->field($model, 'end_time')->widget(TimePicker::class, [
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'minuteStep' => 5,
                    ],
                ]) ?>


            </div>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-body">

                <?= $form->field($model, 'location_id')->widget(Select2::class, [
                    'data' => $locations,
                    'options' => ['placeholder' => 'Выберите локацию'],
                    'pluginOptions' => ['allowClear' => true],
                ]) ?>

                <?= $form->field($model, 'tag_id')->widget(Select2::class, [
                    'data' => $tags,
                    'options' => ['placeholder' => 'Выберите тег'],
                    'pluginOptions' => ['allowClear' => true],
                ]) ?>

                <?= $form->field($model, 'bg_color')->widget(ColorInput::class, [
                    'options' => [
                        'placeholder' => 'Выберите цвет',
                        'value' => '#f3fff4'
                    ],
                ]) ?>

                <?= $form->field($model, 'order_by')->textInput([
                    'placeholder' => 'Укажите порядок сортировки (например, 10, 20, 30...)'
                ]) ?>

                <?= $form->field($model, 'status')->dropDownList($model::getStatusList(), [
                    'prompt' => 'Выберите статус'
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
