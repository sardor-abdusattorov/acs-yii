<?php

use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Settings $model */
/** @var yii\bootstrap5\ActiveForm $form */

$languages = Yii::$app->params['languages'];
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'is_translatable')->checkbox([
                    'id' => 'is-translatable-toggle'
                ]) ?>

                <div id="value-wrapper">

                    <div id="value-single">
                        <?= $form->field($model, 'value')->textarea([
                            'rows' => 6,
                            'id' => 'settings-value',
                            'disabled' => $model->is_translatable,
                        ]) ?>
                    </div>

                    <div id="value-translated">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <?php foreach ($languages as $code => $name): ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $code === Yii::$app->language ? 'active' : '' ?>"
                                            data-bs-toggle="tab" data-bs-target="#lang-<?= $code ?>"
                                            type="button" role="tab"><?= Html::encode($name) ?></button>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="tab-content">
                            <?php foreach ($languages as $code => $name): ?>
                                <div class="tab-pane fade <?= $code === Yii::$app->language ? 'show active' : '' ?>"
                                     id="lang-<?= $code ?>" role="tabpanel">
                                    <?= $form->field($model->translate($code), "[$code]value")->textarea([
                                        'rows' => 4,
                                        'placeholder' => "Значение на {$name}",
                                        'disabled' => !$model->is_translatable,
                                    ])->label("Значение ({$name})") ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <?= $form->field($model, 'image')->widget(FileInput::class, [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'initialPreview' => $model->getImagePreview(),
                        'initialPreviewAsData' => true,
                        'initialPreviewConfig' => $model->getImageConfig(),
                        'showRemove' => true,
                        'showUpload' => false,
                        'browseLabel' => 'Выбрать',
                        'deleteUrl' => Url::to(['settings/delete-image']),
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div>

<div class="form-group mt-3">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', [
        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
    ]) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs(<<<JS
function updateValueVisibility(isTranslatable) {
    document.querySelector('#settings-value').disabled = isTranslatable;
    document.querySelectorAll('#value-translated textarea').forEach(el => {
        el.disabled = !isTranslatable;
    });
}

const toggle = document.getElementById('is-translatable-toggle');
if (toggle) {
    updateValueVisibility(toggle.checked);
    toggle.addEventListener('change', function () {
        updateValueVisibility(this.checked);
    });
}
JS);
?>
