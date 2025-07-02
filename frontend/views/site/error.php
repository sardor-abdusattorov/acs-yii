<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Url;

$this->title = $name;
?>

<section class="error-page">
    <div class="error-page__wrapper">
        <h1 class="error-page__title">404</h1>
        <div class="error-page__message"><?= Yii::t('app', 'Page not found!') ?></div>
        <div class="error-page__description">
            <?= Yii::t('app', "The resource you are looking for doesn't exist or might have been removed.") ?>
        </div>
        <div class="button">
            <a href="<?= Url::to(['/']) ?>" class="button__link" aria-label="<?= Yii::t('app', 'Back to homepage') ?>">
                <span class="button__text"><?= Yii::t('app', 'Back to homepage') ?></span>
            </a>
        </div>
    </div>
</section>
