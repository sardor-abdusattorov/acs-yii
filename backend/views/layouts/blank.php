<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;

AppAsset::register($this);

$this->registerJs('
    document.addEventListener("DOMContentLoaded", function () {
        var url = window.location.href;

        function setActiveMenu(selector) {
            document.querySelectorAll(selector).forEach(function (link) {
                if (link.href === url) {
                    link.classList.add("active");
                    var parent = link.closest(".nav-treeview");
                    if (parent) {
                        parent.style.display = "block";
                        parent.classList.add("menu-open");
                        var prevLink = parent.previousElementSibling;
                        if (prevLink) {
                            prevLink.classList.add("active");
                        }
                    }
                }
            });
        }
        setActiveMenu("ul.nav-sidebar a");
        setActiveMenu("ul.nav-treeview a");

        var flashMessages = {
            success: "' . Yii::$app->session->getFlash('success') . '",
            error: "' . Yii::$app->session->getFlash('error') . '",
            info: "' . Yii::$app->session->getFlash('info') . '",
            warning: "' . Yii::$app->session->getFlash('warning') . '"
        };

        for (var type in flashMessages) {
            if (flashMessages[type]) {
                toastr[type](flashMessages[type]);
            }
        }

        toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: false,
            progressBar: false,
            positionClass: "toast-top-right",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
    });
', View::POS_END);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <?php $this->head() ?>
</head>
<body class="hold-transition auth-fluid-pages pb-0">
    <?php $this->beginBody() ?>

        <?=$content?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
