<?php

use common\components\Editor;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\PageSections $model */
/** @var yii\bootstrap5\ActiveForm $form */

$languages = Yii::$app->params['languages'];

?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-body">

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

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

                            <?= $form->field($model->translate($code), "[$code]subtitle")
                                ->textarea([
                                    'rows' => 6,
                                    'maxlength' => true,
                                    'placeholder' => "Подзаголовок на {$label}"
                                ])
                                ->label("Подзаголовок ({$label})") ?>


                            <?= $form->field($model->translate($code), "[$code]content")->widget(Editor::class, [
                                'options' => [
                                    'useKrajeePresets' => true,
                                    'placeholder' => "Контент на {$label}",
                                ]
                            ])->label("Контент ({$label})") ?>

                        </div>
                    <?php endforeach; ?>
                </div>

                <?= $form->field($model, 'galleryImages[]')->widget(FileInput::class, [
                    'options' => ['multiple' => true, 'accept' => 'image/*'],
                    'pluginOptions' => [
                        'showPreview' => true,
                        'initialPreview'=> $model->getGalleryPreview(),
                        'initialPreviewAsData'=> true,
                        'initialPreviewConfig' => $model->getGalleryConfig(),
                        'showCaption' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseLabel' => 'Выбрать',
                        'deleteUrl' => Url::to(['page-sections/delete-gallery-image']),
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                    ]
                ])->label('Галерея изображений') ?>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-body">

                <?= $form->field($model, 'page_id')->widget(Select2::class, [
                    'data' => $pages,
                    'options' => [
                        'placeholder' => 'Выберите страницу...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]) ?>

                <?= $form->field($model, 'image')->widget(FileInput::class, [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'initialPreview' => $model->getImagePreview(),
                        'initialPreviewAsData' => true,
                        'initialPreviewConfig' => $model->getImageConfig(),
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseLabel' => 'Выбрать',
                        'deleteUrl' => Url::to(['page-sections/delete-image']),
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                    ],
                ]) ?>

                <?= $form->field($model, 'sort')->textInput() ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
