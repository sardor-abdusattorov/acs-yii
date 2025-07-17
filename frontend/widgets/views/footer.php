<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$language = Yii::$app->language;

$logoDark = '/images/aral_logo/dark/logo_footer_new_en.svg';
$logoLight = '/images/aral_logo/light/logo_footer_new_en.svg';
$acdfLight = '/images/acdf_logo/light/logo-en.svg';
$acdfDark = '/images/acdf_logo/dark/logo-en.svg';

switch ($language) {
    case 'ru':
        $logoDark = '/images/aral_logo/dark/logo_footer_new_ru.svg';
        $logoLight = '/images/aral_logo/light/logo_footer_new_ru.svg';
        $acdfLight = '/images/acdf_logo/light/logo-ru.svg';
        $acdfDark = '/images/acdf_logo/dark/logo-ru.svg';
        break;
    case 'uz':
        $logoDark = '/images/aral_logo/dark/logo_footer_new_uz.svg';
        $logoLight = '/images/aral_logo/light/logo_footer_new_uz.svg';
        $acdfLight = '/images/acdf_logo/light/logo-uz.svg';
        $acdfDark = '/images/acdf_logo/dark/logo-uz.svg';
        break;
    case 'ka':
        $logoDark = '/images/aral_logo/dark/logo_footer_new_ka.svg';
        $logoLight = '/images/aral_logo/light/logo_footer_new_ka.svg';
        break;
}

$acdf = $settings['acdf'] ?? '';
$acdf_address = $settings['acdf_address'] ?? '';
$acdf_phone = $settings['acdf_phone'] ?? '';
$acdf_email = $settings['acdf_email'] ?? '';

?>

<!-- Footer -->
<footer class="footer">
    <div class="container-fluid">
        <div class="d-flex align-items-start footer_row">
            <div class="footer_col">
                <div class="footer_logo">
                    <a class="d-block footer_logo" href="<?= Url::to(['/', $language=>Yii::$app->language])?>">
                        <img src="<?= $logoDark ?>" alt="logo" class="logo_image_footer dark">
                        <img src="<?= $logoLight ?>" alt="logo" class="logo_image_footer light">
                    </a>
                </div>
            </div>
            <div class="footer_col">
                <div class="contacts">
                    <p class="section_title">
                        <?=Yii::t('app', 'Contacts')?>
                    </p>
                    <p>
                        <?=$acdf?>
                    </p>
                    <p>
                        <?=$acdf_address?>
                    </p>
                    <p>
                        <?=Yii::t('app', 'Phone')?>:
                        <a href="tel:<?=$acdf_phone?>">
                            <?=$acdf_phone?>
                        </a>
                    </p>
                </div>
                <div class="general_inquiries mt-3">
                    <p class="section_title m-0">
                        <?=Yii::t('app', 'General inquiries')?>
                    </p>
                    <p class="m-0">
                        <a href="mailto:<?=$acdf_email?>"><?=$acdf_email?></a>
                    </p>
                </div>
                <div class="social-media mt-3">
                    <p class="section_title">
                        <?=Yii::t('app', 'Social media')?>
                    </p>

                    <?php if(!empty($social_links)): ?>
                        <?php foreach ($social_links as $social_link): ?>
                            <a href="<?=$social_link->link?>" target="_blank" aria-label="<?=$social_link->name?>">
                                <i class="<?=$social_link->class?> fa-2x"></i>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
            <div class="footer_col">
                <div class="organisers">
                    <p class="section_title m-0">
                        <?=Yii::t('app', 'Organiser')?>
                    </p>
                    <p>
                        <?=$acdf?>
                    </p>
                    <a class="d-block mt-4 acdf_logo" href="https://acdf.uz/" target="_blank">
                        <img src="<?= $acdfLight ?>" alt="logo" class="logo_image_footer light">
                        <img src="<?= $acdfDark ?>" alt="logo" class="logo_image_footer dark">
                    </a>
                </div>
                <div class="policies mobile mt-4 pt-3">
                    <?php if(!empty($menus)): ?>
                        <?php foreach ($menus as $menu): ?>

                            <a href="<?=$menu->link?>" class="me-3">
                                <?= Html::encode($menu->title ?? '') ?>
                            </a>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="footer_col">
                <div class="subscribe_wrap">
                    <p class="section_title mb-2">
                        <?=Yii::t('app', 'Newsletter')?>
                    </p>

                    <?php $form = ActiveForm::begin([
                        'action' => ['/site/subscribe'],
                        'method' => 'post',
                        'options' => ['class' => 'validate'],
                    ]); ?>

                    <div class="subscribe_form d-flex">
                        <?= $form->field($subscribers, 'email', [
                            'options' => ['class' => 'w-100'],
                            'template' => "{input}\n{error}",
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ])->textInput([
                            'type' => 'email',
                            'placeholder' => 'Email',
                            'required' => true,
                            'class' => 'required email w-100' . ($subscribers->hasErrors('email') ? ' is-invalid' : ''),
                        ]) ?>

                        <?= Html::submitInput(Yii::t('app', 'Subscribe'), ['class' => 'btn-white']) ?>
                    </div>


                    <?php ActiveForm::end(); ?>

                    <div class="policies mt-4 pt-3">
                        <?php if(!empty($menus)): ?>
                            <?php foreach ($menus as $menu): ?>

                                <a href="<?=$menu->link?>" class="me-3">
                                    <?= Html::encode($menu->title ?? '') ?>
                                </a>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
