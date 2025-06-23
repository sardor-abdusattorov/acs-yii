<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use backend\widgets\Footer;
use backend\widgets\Header;
use backend\widgets\Sidebar;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
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
    <?php $this->head() ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?=Yii::getAlias('@web') ?>/dist/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php $this->beginBody() ?>

<div class="wrapper">

    <!-- Preloader -->
<!--    <div class="preloader flex-column justify-content-center align-items-center">-->
<!--        <img class="animation__shake" src="/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
<!--    </div>-->

    <?= Header::widget()?>

    <?= Sidebar::widget()?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-6">
                        <?= Breadcrumbs::widget([
                            'links' => $this->params['breadcrumbs'] ?? '',
                            'options' => ['class' => 'float-sm-left'],
                        ]) ?>
                    </div>
                    <div class="col-6 text-right">
                        <span id="current-time" class="font-weight-bold"></span>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <?= $content ?>
        </section>

    </div>

    <?= Footer::widget()?>

</div>
<script>
    let isDarkMode = localStorage.getItem('darkMode') === 'true';
    const navbar = document.querySelector('.navbar');
    const sidebar = document.querySelector('.main-sidebar');
    const darkModeIcon = document.querySelector('#darkModeToggle i');
    function updateTheme() {
        document.body.classList.toggle('dark-mode', isDarkMode);
        if (navbar) {
            navbar.classList.toggle('navbar-dark', isDarkMode);
            navbar.classList.toggle('bg-dark', isDarkMode);
            navbar.classList.toggle('navbar-light', !isDarkMode);
            navbar.classList.toggle('bg-light', !isDarkMode);
        }

        if (darkModeIcon) {
            darkModeIcon.classList.toggle('fa-sun', isDarkMode);
            darkModeIcon.classList.toggle('fa-moon', !isDarkMode);
        }
    }
    updateTheme();
    const darkModeToggle = document.querySelector('#darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function (e) {
            e.preventDefault();
            isDarkMode = !isDarkMode;
            updateTheme();
            localStorage.setItem('darkMode', isDarkMode);
        });
    }
</script>



<?php
$this->registerJs(<<<JS
function updateTime() {
    let now = new Date();
    let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
    document.getElementById('current-time').innerText = now.toLocaleString('ru-RU', options);
}
setInterval(updateTime, 1000);
updateTime();
JS);
?>


<?php
$this->registerJs("
    $(document).ready(function() {
            $(document).on('click', '.btn-kv-close', function() {
               $('#kvFileinputModal').modal('hide');
            });
    });
    // END
", \yii\web\View::POS_END);
?>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
