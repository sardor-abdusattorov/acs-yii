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
    <div class="wrapper d-flex">
        <?= $content ?>
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
