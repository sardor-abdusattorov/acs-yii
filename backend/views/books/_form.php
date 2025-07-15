<?php

use common\components\Editor;
use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Books $model */
/** @var yii\bootstrap5\ActiveForm $form */

$languages = Yii::$app->params['languages'];

?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8">
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
                            <?= $form->field($model->translate($code), "[$code]name")
                                ->textInput(['maxlength' => true, 'placeholder' => "Название на {$label}"])
                                ->label("Название ({$label})") ?>

                            <?= $form->field($model->translate($code), "[$code]author")
                                ->textarea([
                                    'rows' => 6,
                                    'maxlength' => true,
                                    'placeholder' => "Автор на {$label}"
                                ])
                                ->label("Автор ({$label})") ?>


                            <?= $form->field($model->translate($code), "[$code]description")->widget(Editor::class, [
                                'options' => [
                                    'useKrajeePresets' => true,
                                    'placeholder' => "Описание на {$label}",
                                ]
                            ])->label("Описание ({$label})") ?>

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
                        'deleteUrl' => Url::to(['books/delete-image']),
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                    ],
                ]) ?>

                <?= $form->field($model, 'file')->widget(FileInput::class, [
                    'options' => ['accept' => '.pdf,.doc,.docx,.epub'],
                    'pluginOptions' => [
                        'showPreview' => true,
                        'initialPreview' => $model->getFilePreview(),
                        'initialPreviewAsData' => true,
                        'initialPreviewConfig' => $model->getFileConfig(),
                        'showCaption' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseLabel' => 'Выбрать',
                        'allowedFileExtensions' => ['pdf', 'doc', 'docx', 'epub'],
                        'previewFileType' => 'any'
                    ],
                ])
                    ->hint('Если не загрузите файл — кнопка "Download" отображаться не будет') ?>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'link')
                    ->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Если заполнено — будет кнопка "Buy"',
                        'title' => 'Оставьте пустым, если не нужна кнопка "Buy"'
                    ])
                    ->hint('Оставьте поле пустым, если не хотите показывать кнопку «Buy»') ?>

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
