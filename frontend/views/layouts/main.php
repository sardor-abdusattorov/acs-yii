<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\widgets\Footer;
use frontend\widgets\Header;
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

<!--    <link rel="profile" href="https://gmpg.org/xfn/11"/>-->

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


<div class="register_modal modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal_header">
                <div class="modal_logo">
                    <img src="/images/modal_logo.svg" alt="logo" class="logo_img">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4 class="content_title">
                    Register now for the Aral Culture Summit!
                </h4>
                <p class="content_subtitle">
                    Complete the form below to sign up for the Summit
                </p>

                <form class="modal_form">
                    <!-- Name -->
                    <div class="row g-3 form_inputs">
                        <div class="col-md-6">
                            <label class="form-label">First name</label>
                            <input type="text" class="form_input" placeholder="First name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last name</label>
                            <input type="text" class="form_input" placeholder="Last name" required>
                        </div>

                        <!-- Email / Phone -->
                        <div class="col-md-6">
                            <label class="form-label">E-mail</label>
                            <input type="email" class="form_input" placeholder="you@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone number</label>
                            <input type="tel" class="form_input" placeholder="+998 .." required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Street address</label>
                            <input type="text" class="form_input" placeholder="Street address" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form_input" placeholder="City" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State / Province</label>
                            <input type="text" class="form_input" placeholder="State">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Postal / ZIP</label>
                            <input type="text" class="form_input" placeholder="ZIP">
                        </div>
                    </div>

                    <div class="row checkbox_row">
                        <div class="form-group">
                            <div class="group-title">
                                How did you hear about the Summit?
                            </div>
                            <div class="d-flex flex-wrap checkbox_wrapper">
                                <label class="custom-checkbox">
                                    <input type="checkbox" name="source[]" value="Website">
                                    <span class="checkmark"></span>
                                    Website
                                </label>

                                <label class="custom-checkbox">
                                    <input type="checkbox" name="source[]" value="Friend/Colleague">
                                    <span class="checkmark"></span>
                                    Friend/Colleague
                                </label>

                                <label class="custom-checkbox">
                                    <input type="checkbox" name="source[]" value="Online research">
                                    <span class="checkmark"></span>
                                    Online research
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="group-title">
                                How many will attend? (multiple choice allowed)
                            </div>
                            <div class="d-flex flex-wrap checkbox_wrapper">
                                <label class="custom-checkbox">
                                    <input type="checkbox" name="source[]" value="Website">
                                    <span class="checkmark"></span>
                                    July 4th
                                </label>

                                <label class="custom-checkbox">
                                    <input type="checkbox" name="source[]" value="Friend/Colleague">
                                    <span class="checkmark"></span>
                                    July 5th
                                </label>

                                <label class="custom-checkbox">
                                    <input type="checkbox" name="source[]" value="Online research">
                                    <span class="checkmark"></span>
                                    July 6th
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="submit_button">REGISTER</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
