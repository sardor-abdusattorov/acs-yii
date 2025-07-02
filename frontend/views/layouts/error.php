<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\widgets\Footer;
use frontend\widgets\Header;
use frontend\widgets\RegistrationForm;
use kartik\growl\Growl;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

$languages = Yii::$app->params['languages'];
$language = Yii::$app->language;


switch ($language) {
    case 'ru':
        $logo = '/images/logo_home/logo_home_new_ru.svg';
        break;
    case 'uz':
        $logo = '/images/logo_home/logo_home_new_uz.svg';
        break;
    case 'ka':
        $logo = '/images/logo_home/logo_home_new_ka.svg';
        break;
    case 'en':
    default:
        $logo = '/images/logo_home/logo_home_new_en.svg';
        break;
}


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
        <link rel="manifest" href="/images/favicon/site.webmanifest">
        <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5">

        <!-- Chrome, Firefox OS and Opera -->
        <meta name="theme-color" content="#003DA7">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#003DA7">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#003DA7">

        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>


    <?php //= Header::widget()?>

    <main>
        <div class="wrapper error_page">
            <section class="hero error_page w-100">
                <div class="wrapper_header_hero d-flex" style="background-image: url('/images/hero_background_image.png')">
                    <div class="main_header pt-lg-5 d-flex align-items-center flex-row flex-lg-column">
                        <div class="mobile_logo">
                            <a href="#" class="logo_link">
                                <img class="dark" src="/images/logo_header/dark/logo_header_new_en.svg" alt="Logo">
                                <img class="light" src="/images/logo_header/light/logo_header_new_en.svg" alt="Logo">
                            </a>
                        </div>
                        <div class="header-actions d-flex align-items-center flex-row flex-lg-column">
                            <div class="toggle"></div>
                            <div class="languages ml-4 ml-lg-0 mt-lg-4 py-4 py-lg-0 my-md-0 d-flex text-center">

                                <?php foreach ($languages as $code => $label): ?>
                                    <a rel="alternate" hreflang="<?= strtoupper($code) ?>" href="<?= Url::current(['language' => $code]) ?>" class="d-block <?= $code === $language ? 'active' : '' ?>">
                                        <?= strtoupper($code) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="error_container">
                        <div class="logo-container">
                            <a href="<?=Url::to(['/'])?>">
                                <img src="<?= Html::encode($logo) ?>" alt="Logo">
                            </a>
                        </div>

                        <?= $content ?>
                    </div>
                </div>

            </section>

        </div>

        <?= Footer::widget()?>
    </main>

    <?= RegistrationForm::widget()?>

    <?php

    foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
        echo Growl::widget([
            'type' => match ($type) {
                'success' => Growl::TYPE_SUCCESS,
                'danger', 'error' => Growl::TYPE_DANGER,
                'warning' => Growl::TYPE_WARNING,
                'info' => Growl::TYPE_INFO,
                default => Growl::TYPE_INFO,
            },
            'title' => Yii::t('app', 'Notification'),
            'icon' => 'fas fa-info-circle',
            'body' => $message,
            'showSeparator' => true,
            'delay' => 0,
            'pluginOptions' => [
                'showProgressbar' => false,
                'delay' => 3500,
                'allow_dismiss' => false,
                'placement' => ['from' => 'top', 'align' => 'right'],
            ]
        ]);
    }
    ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
