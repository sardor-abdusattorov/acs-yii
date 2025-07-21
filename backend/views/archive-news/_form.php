<?php

use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\ArchiveNews $model */
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

                            <?= $form->field($model->translate($code), "[$code]description")
                                ->textarea([
                                    'rows' => 8,
                                    'maxlength' => true,
                                    'placeholder' => "Описание на {$label}"
                                ])
                                ->label("Описание ({$label})") ?>

                        </div>
                    <?php endforeach; ?>
                </div>

                <?= $form->field($model, 'image')->widget(FileInput::class, [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'initialPreview' => $model->getImagePreview(),
                        'initialPreviewAsData' => true,
                        'initialPreviewConfig' => $model->getImageConfig(),
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseLabel' => 'Выбрать',
                        'deleteUrl' => Url::to(['archive-news/delete-image']),
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                    ],
                ]) ?>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'order_by')->textInput([
                    'placeholder' => 'Укажите порядок сортировки (например, 10, 20, 30...)'
                ]) ?>

                <?= $form->field($model, 'status', [
                    'options' => ['class' => 'form-group'],
                    'errorOptions' => ['class' => 'text-danger']
                ])->widget(SwitchInput::class, [
                    'type' => SwitchInput::CHECKBOX,
                    'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                        'onColor' => 'success',
                        'offColor' => 'danger',
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
