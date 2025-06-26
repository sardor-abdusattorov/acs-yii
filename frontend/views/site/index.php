<?php

use frontend\widgets\Archive;
use frontend\widgets\Location;
use frontend\widgets\Program;
use frontend\widgets\Research;
use yii\helpers\Html;
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

?>
<section class="menu_bar hero opened">
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

        <div class="hero-container px-3 px-md-5 py-3 p-md-5">
            <div class="logo-container">
                <img class="w-50" src="<?= Html::encode($logo) ?>" alt="Logo">
            </div>
            <div class="reg_button_container mt-4 mt-md-5 pl-1 pl-md-2">
                <button class="reg_button" data-bs-toggle="modal" data-bs-target="#registerModal">
                   <?=Yii::t('app', 'Register now')?> ↘
                </button>
            </div>

            <div class="container hero-text">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p>
                            <?=Yii::t('app', 'A future for the planet <br>and Karakalpakstan')?>
                        </p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="text-end">
                            <?=Yii::t('app', 'Autumn<br>2026')?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="social_media_links">
                <a href="https://www.instagram.com/aral.culture.summit/" class="social_link" title="Instagram" target="_blank" aria-label="Instagram">
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="hero_content d-flex">
        <div class="hero_content_header">
            <span>Overview</span>
        </div>
        <div class="main_content">
            <div class="main_section_hero p-md-5 p-3">
                <div class="introduction_block">
                    <div class="introduction_block_title">
                        <p>
                            ARAL CULTURE SUMMIT IS AN EMERGENT INITIATIVE DEDICATED TO THE SOCIAL AND ENVIRONMENTAL TRANSFORMATION OF THE ARAL SEA REGION THROUGH ART, CULTURE, SCIENCE, AND DESIGN.
                        </p>
                    </div>
                    <div class="introduction_content">
                        <div class="image">
                            <img src="/images/aral_sea.png" alt="Aral Sea" width="75%">
                        </div>

                        <div class="text_block">
                            <h2>The Summit</h2>
                            <p>
                                Aral Culture Summit brings together local and international activists, artists and scientists to explore and implement ecological, social and cultural pathways to sustainable development of Karakalpakstan.
                            </p>
                            <p>
                                It will act as both an itinerant platform for exchanging ideas and a placemaking initiative to revive the regional landscape and strengthen the community identity, while attracting new businesses that align with the principles of circular economy, creating sustainable economic growth.
                            </p>
                        </div>
                        <div class="text_block">
                            <h2>The Mission</h2>
                            <p>
                                Aral Culture Summit aims to draw attention to the ecological challenges and opportunities in and around Karakalpakstan, empower and unite the local community, and evolve the region into an environmentally sustainable and culturally enriching destination.
                            </p>
                        </div>
                    </div>
                    <div class="embed-responsive">
                        <iframe width="100%" height="700" src="https://www.youtube.com/embed/ShbkMi0sIAI?si=8qWELUYukPF66h9y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= Program::widget()?>

<?= Location::widget()?>

<?= Research::widget()?>

<?= Archive::widget()?>



