<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var common\models\SocialLinks $model */
/** @var yii\bootstrap5\ActiveForm $form */

?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?php
                $iconOptions = [
                    'fab fa-facebook-f' => 'Facebook',
                    'fab fa-twitter' => 'Twitter',
                    'fab fa-instagram' => 'Instagram',
                    'fab fa-linkedin-in' => 'LinkedIn',
                    'fab fa-youtube' => 'YouTube',
                    'fab fa-telegram-plane' => 'Telegram',
                    'fab fa-whatsapp' => 'WhatsApp',
                    'fab fa-tiktok' => 'TikTok',
                    'fab fa-vk' => 'VK',
                    'fab fa-github' => 'GitHub',
                    'fab fa-discord' => 'Discord',
                    'fab fa-pinterest-p' => 'Pinterest',
                    'fab fa-snapchat-ghost' => 'Snapchat',
                    'fab fa-skype' => 'Skype',
                    'fab fa-reddit-alien' => 'Reddit',
                    'fab fa-tumblr' => 'Tumblr',
                    'fab fa-slack-hash' => 'Slack',
                ];
                ?>

                <?= $form->field($model, 'class')->widget(Select2::class, [
                    'data' => $iconOptions,
                    'options' => ['placeholder' => 'Выберите иконку...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('function (icon) {
                            if (!icon.id) return icon.text;
                            return `<i class="${icon.id} me-2"></i>` + icon.text;
                        }'),
                        'templateSelection' => new JsExpression('function (icon) {
                            if (!icon.id) return icon.text;
                            return `<i class="${icon.id} me-1"></i>` + icon.text;
                        }'),
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    ],
                ]) ?>

                <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <?= $form->field($model, 'order_by')->textInput([
                    'placeholder' => 'Укажите порядок сортировки (например, 10, 20, 30...)'
                ]) ?>

                <?= $form->field($model, 'status')->dropDownList([
                    1 => 'Активно',
                    0 => 'Неактивно',
                ], ['prompt' => 'Выберите статус']) ?>
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
