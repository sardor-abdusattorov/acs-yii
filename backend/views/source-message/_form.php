<?php

use common\models\Message;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\components\Editor;

/** @var yii\web\View $this */
/** @var common\models\SourceMessage $model */
/** @var array $languages */
/** @var yii\bootstrap5\ActiveForm $form */

$languages = Yii::$app->params['languages'];

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'category')->hiddenInput(['value' => 'app'])->label(false) ?>
                <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

                <h4 class="mt-4">Переводы</h4>

                <!-- Вкладки по языкам -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <?php foreach ($languages as $code => $name): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $code === Yii::$app->language ? 'active' : '' ?>"
                                    data-bs-toggle="tab"
                                    data-bs-target="#lang-<?= $code ?>"
                                    type="button" role="tab">
                                <?= Html::encode($name) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Контент вкладок -->
                <div class="tab-content">
                    <?php foreach ($languages as $code => $name): ?>
                        <?php
                        $translation = Message::findOne(['id' => $model->id, 'language' => $code]);
                        $value = $translation ? $translation->translation : '';
                        ?>
                        <div class="tab-pane fade <?= $code === Yii::$app->language ? 'show active' : '' ?>"
                             id="lang-<?= $code ?>" role="tabpanel">

                            <div class="form-group">
                                <label for="message-translation-<?= $code ?>">Перевод (<?= strtoupper($code) ?>)</label>
                                <textarea
                                        class="form-control"
                                        name="Message[<?= $code ?>][translation]"
                                        id="message-translation-<?= $code ?>"
                                        rows="6"><?= Html::encode($value) ?></textarea>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
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
