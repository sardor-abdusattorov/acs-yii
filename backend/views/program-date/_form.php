<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProgramDate $model */
/** @var kartik\form\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'date')->widget(DatePicker::class, [
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                    ],
                    'options' => [
                        'placeholder' => 'Выберите дату...',
                        'autocomplete' => 'off',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group mt-3">
    <?= Html::submitButton(
        $model->isNewRecord ? 'Добавить' : 'Обновить',
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    ) ?>
</div>
<?php ActiveForm::end(); ?>
