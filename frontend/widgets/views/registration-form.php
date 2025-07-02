<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $model common\models\Registration */

$language = Yii::$app->language;

switch ($language) {
    case 'ru':
        $logoDark = '/images/aral_logo/dark/logo_footer_new_ru.svg';
        $logoLight = '/images/aral_logo/light/logo_footer_new_ru.svg';
        break;
    case 'uz':
        $logoDark = '/images/aral_logo/dark/logo_footer_new_uz.svg';
        $logoLight = '/images/aral_logo/light/logo_footer_new_uz.svg';
        break;
    case 'ka':
        $logoDark = '/images/aral_logo/dark/logo_footer_new_ka.svg';
        $logoLight = '/images/aral_logo/light/logo_footer_new_ka.svg';
        break;
    case 'en':
    default:
        $logoDark = '/images/aral_logo/dark/logo_footer_new_en.svg';
        $logoLight = '/images/aral_logo/light/logo_footer_new_en.svg';
        break;
}

?>

<div class="register_modal modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal_header">
                <div class="modal_logo">
                    <img src="<?= $logoDark ?>" alt="logo" class="logo_img dark">
                    <img src="<?= $logoLight ?>" alt="logo" class="logo_img light">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4 class="content_title">
                    <?= Yii::t('app', 'Register now for the Aral Culture Summit!') ?>
                </h4>
                <p class="content_subtitle">
                    <?= Yii::t('app', 'Complete the form below to sign up for the Summit') ?>
                </p>

                <?php $form = ActiveForm::begin([
                    'action' => ['/site/register'],
                    'options' => ['class' => 'modal_form'],
                ]); ?>


                <div class="row g-3 form_inputs">

                    <div class="col-md-6">
                        <?= $form->field($model, 'first_name')->textInput([
                            'class' => 'form_input',
                            'placeholder' => Yii::t('app', 'First Name'),
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'last_name')->textInput([
                            'class' => 'form_input',
                            'placeholder' => Yii::t('app', 'Last Name'),
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'email')->input('email', [
                            'class' => 'form_input',
                            'placeholder' => Yii::t('app', 'you@example.com'),
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                            'mask' => '+\\9\\9\\8 99 999-99-99',
                            'options' => [
                                'class' => 'form_input',
                                'placeholder' => '+998 99 999 99 99',
                                'required' => true,
                            ],
                        ]) ?>
                    </div>

                    <div class="col-12">
                        <?= $form->field($model, 'address')->textInput([
                            'class' => 'form_input',
                            'placeholder' => Yii::t('app', 'Address'),
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'city')->textInput([
                            'class' => 'form_input',
                            'placeholder' => Yii::t('app', 'City'),
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'state')->textInput([
                            'class' => 'form_input',
                            'placeholder' => Yii::t('app', 'State / Province'),
                        ]) ?>
                    </div>

                    <div class="col-md-12">
                        <?= $form->field($model, 'postal_code')->textInput([
                            'class' => 'form_input',
                            'placeholder' => Yii::t('app', 'Postal / ZIP'),
                        ]) ?>
                    </div>

                </div>

                <div class="row checkbox_row">
                    <div class="form-group">
                        <?= $form->field($model, 'sources', [
                            'template' => "<div class=\"group-title\">" . Yii::t('app', 'How did you hear about the Summit?') . "</div>\n{input}\n{error}",
                            'options' => ['tag' => 'div', 'class' => 'form-group'],
                        ])->checkboxList([
                            'Website' => Yii::t('app', 'Website'),
                            'Friend/Colleague' => Yii::t('app', 'Friend/Colleague'),
                            'Online research' => Yii::t('app', 'Online research'),
                        ], [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return '<label class="custom-checkbox">
                    <input type="checkbox" name="' . $name . '" value="' . $value . '" ' . ($checked ? 'checked' : '') . '>
                    <span class="checkmark"></span>
                    ' . $label . '
                </label>';
                            },
                            'tag' => 'div',
                            'class' => 'd-flex flex-wrap checkbox_wrapper',
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'attendance_days', [
                            'template' => "<div class=\"group-title\">" . Yii::t('app', 'How many will attend? (multiple choice allowed)') . "</div>\n{input}\n{error}",
                            'options' => ['tag' => 'div', 'class' => 'form-group'],
                        ])->checkboxList([
                            'July 4th' => Yii::t('app', 'July 4th'),
                            'July 5th' => Yii::t('app', 'July 5th'),
                            'July 6th' => Yii::t('app', 'July 6th'),
                        ], [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return '<label class="custom-checkbox">
                    <input type="checkbox" name="' . $name . '" value="' . $value . '" ' . ($checked ? 'checked' : '') . '>
                    <span class="checkmark"></span>
                    ' . $label . '
                </label>';
                            },
                            'tag' => 'div',
                            'class' => 'd-flex flex-wrap checkbox_wrapper',
                        ]) ?>
                    </div>
                </div>


                <button type="submit" class="submit_button">
                    <?=Yii::t('app', 'Register')?>
                </button>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$('#registerModal').on('hidden.bs.modal', function () {
    const form = $(this).find('form')[0];
    if (form) {
        form.reset();
    }
    $(this).find('.is-invalid').removeClass('is-invalid');
    $(this).find('.invalid-feedback').text('');
});
JS;
$this->registerJs($js);
?>

