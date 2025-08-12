<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Sections $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'status')->dropDownList([
                    1 => 'Активно',
                    0 => 'Не активно',
                ], ['prompt' => 'Выберите статус']) ?>

                <?= $form->field($model, 'is_opened', [
                    'options' => ['class' => 'form-group'],
                    'errorOptions' => ['class' => 'text-danger']
                ])->widget(SwitchInput::class, [
                    'type' => SwitchInput::CHECKBOX,
                    'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                        'onColor' => 'primary',
                        'offColor' => 'secondary',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
