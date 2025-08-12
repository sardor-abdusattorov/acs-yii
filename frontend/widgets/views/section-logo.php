<?php

use yii\helpers\Url;

$language = Yii::$app->language;

switch ($language) {
    case 'ru':
        $logoDark = '/images/logo_header/dark/logo_header_new_ru.svg';
        $logoLight = '/images/logo_header/light/logo_header_new_ru.svg';
        break;
    case 'uz':
        $logoDark = '/images/logo_header/dark/logo_header_new_uz.svg';
        $logoLight = '/images/logo_header/light/logo_header_new_uz.svg';
        break;
    case 'ka':
        $logoDark = '/images/logo_header/dark/logo_header_new_ka.svg';
        $logoLight = '/images/logo_header/light/logo_header_new_ka.svg';
        break;
    case 'en':
    default:
        $logoDark = '/images/logo_header/dark/logo_header_new_en.svg';
        $logoLight = '/images/logo_header/light/logo_header_new_en.svg';
        break;
}

?>

<div class="section_logo">
    <a href="<?= Url::to(['/']) ?>" class="logo_link">
        <img class="logo_image_header dark" src="<?=$logoDark?>" alt="Logo">
        <img class="logo_image_header light" src="<?=$logoLight?>" alt="Logo">
    </a>
</div>