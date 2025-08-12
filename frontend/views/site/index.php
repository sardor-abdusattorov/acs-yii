<?php

use common\components\FileUpload;
use common\components\StaticFunctions;
use frontend\widgets\Location;
use frontend\widgets\Program;
use frontend\widgets\SectionLogo;
use yii\helpers\Html;
use yii\helpers\Url;


$languages = Yii::$app->params['languages'];
$language = Yii::$app->language;

$tabWidth = 60;
$menuTabCount = count(array_filter($sections, fn($section) => !$section->is_opened && $section->status == 1));
$totalMenuWidth = $menuTabCount * $tabWidth;

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

$youtube_link = $settings['youtube_link'] ?? '';
?>

<?php if (!empty($sections)): ?>
    <?php foreach ($sections as $section): ?>

        <?php if ($section->name == 'aral_school'): ?>
        <section data-width="<?= $totalMenuWidth ?>"
                 data-redirect="<?= Html::encode($section->redirect_url) ?>"
                 class="menu_bar <?= $section->name ?> redirect-section <?= $section->status == 0 ? 'disabled' : '' ?>">
            <div class="section_header">
                <p class="first_title"><?= Html::encode(strtoupper(str_replace('_', ' ', $section->name))) ?></p>
            </div>
        </section>

        <?php elseif ($section->name == 'hero'): ?>
            <section data-width="<?= $totalMenuWidth ?>" class="menu_bar <?= $section->name ?> <?= $section->is_opened == 1 ? 'opened' : '' ?> <?= $section->status == 0 ? 'disabled' : '' ?>"
                <?= $section->is_opened == 1 ? 'style="width: calc(100% - '.$totalMenuWidth.'px);"' : '' ?>>

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
<!--                            <div class="languages ml-4 ml-lg-0 mt-lg-4 py-4 py-lg-0 my-md-0 d-flex text-center">-->
<!--                                --><?php //foreach ($languages as $code => $label): ?>
<!--                                    <a rel="alternate" hreflang="--><?php //= strtoupper($code) ?><!--" href="--><?php //= Url::current(['language' => $code]) ?><!--" class="d-block --><?php //= $code === $language ? 'active' : '' ?><!--">-->
<!--                                        --><?php //= strtoupper($code) ?>
<!--                                    </a>-->
<!--                                --><?php //endforeach; ?>
<!--                            </div>-->
                        </div>
                    </div>

                    <div class="hero-container">
                        <div class="logo-container">
                            <img class="w-50" src="<?= Html::encode($logo) ?>" alt="Logo">
                        </div>
                        <div class="reg_button_container mt-4 mt-md-5 pl-1 pl-md-2">
                            <a href="https://95a8f6e7.sibforms.com/serve/MUIFAFNnFlzJwGA0A0f7_DNLkzMeFt3lSeDkMU0Nev9O7WE8y3xupK0e3j4DmHphBPHHDWHiyUoX6TgPAtkcnZowNNA6SYkJIzdTZdB8lHVoYOLBB8TkBhesW0CsZJogWX3TdfTv71RKgpSEjmljKTaPMoTceo5JIQDPfmyv5UvTY6fdi7ExLEYwNHwDx6JUf5Cr2REOV9BhQw08?fbclid=PAZXh0bgNhZW0CMTEAAaeg_ouLeE3RoIBcLCUCruASNTOIkYyKaAp5f6HT7xa9Tfkpy4FAELFbPV7Wjg_aem_nV-i_lS5aLrL6lJW8rFsjA&clckid=daa04bb0" class="reg_button" target="_blank">
                                <?=Yii::t('app', 'Subscribe to newsletter')?> ↘
                            </a>
                        </div>

                        <div class="hero-text">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <p><?= Yii::t('app', 'A future for the planet <br>and Karakalpakstan') ?></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p class="text-end"><?= Yii::t('app', 'Autumn<br>2026') ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="social_media_links">
                            <?php if (!empty($social_links)): ?>
                                <?php foreach ($social_links as $social_link): ?>
                                    <a href="<?= $social_link->link ?>" class="social_link" title="<?= $social_link->name ?>" target="_blank" aria-label="<?= $social_link->name ?>">
                                        <i class="<?= $social_link->class ?> fa-2x"></i>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="hero_content d-flex">
                    <div class="hero_content_header">
                        <span><?= Yii::t('app', 'Overview') ?></span>
                    </div>
                    <div class="main_content">
                        <?php if (!empty($hero)): ?>
                            <div class="main_section_hero">
                                <div class="introduction_block">
                                    <div class="introduction_block_title">
                                        <p><?= $hero->title ?></p>
                                    </div>
                                    <div class="introduction_content">
                                        <?php $image = StaticFunctions::getImage($hero->image, 'page-sections', $hero->id) ?>
                                        <div class="image">
                                            <a href="<?= $image ?>" data-fancybox="gallery" class="d-flex align-items-center w-100">
                                                <img src="<?= $image ?>" width="75%" alt="image">
                                            </a>
                                        </div>
                                        <?= $hero->content ?>
                                    </div>
                                    <div class="embed-responsive">
                                        <?= $youtube_link ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

        <?php elseif ($section->name == 'program'): ?>
            <section data-width="<?= $totalMenuWidth ?>" class="menu_bar <?= $section->name ?> <?= $section->is_opened == 1 ? 'opened' : '' ?> <?= $section->status == 0 ? 'disabled' : '' ?>"
                <?= $section->is_opened == 1 ? 'style="width: calc(100% - '.$totalMenuWidth.'px);"' : '' ?>>
                <?= Program::widget()?>
            </section>

        <?php elseif ($section->name == 'location'): ?>
            <section data-width="<?= $totalMenuWidth ?>" class="menu_bar <?= $section->name ?> <?= $section->is_opened == 1 ? 'opened' : '' ?> <?= $section->status == 0 ? 'disabled' : '' ?>"
                <?= $section->is_opened == 1 ? 'style="width: calc(100% - '.$totalMenuWidth.'px);"' : '' ?>>
                <?= Location::widget() ?>
            </section>

        <?php elseif ($section->name == 'research'): ?>
            <section data-width="<?= $totalMenuWidth ?>" class="menu_bar <?= $section->name ?> <?= $section->is_opened == 1 ? 'opened' : '' ?> <?= $section->status == 0 ? 'disabled' : '' ?>"
                <?= $section->is_opened == 1 ? 'style="width: calc(100% - '.$totalMenuWidth.'px);"' : '' ?>>

                <div class="section_header">
                    <p class="first_title"><?=Yii::t('app', 'Research')?></p>
                </div>
                <div class="main_section">
                    <div class="main_section_header">
                        <?= SectionLogo::widget()?>
                        <div class="header_navigation">
                            <ul>
                                <li>
                                    <a href="#books" class="navigation_link scroll-link">
                                        <?=Yii::t('app', 'Books')?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#articles" class="navigation_link scroll-link">
                                        <?=Yii::t('app', 'Articles')?>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="nav_link back_link">
                                        ← <?=Yii::t('app', 'Back')?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="main_section_hero">

                        <div class="research_books" id="books">
                            <h2 class="section_title">
                                <?=Yii::t('app', 'Books')?>
                            </h2>
                            <div class="research_header">
                                <div class="col">
                                    <?=Yii::t('app', 'Name')?>
                                </div>
                                <div class="col">
                                    <?=Yii::t('app', 'Author')?>
                                </div>
                                <div class="col">
                                    <?=Yii::t('app', 'Access')?>
                                </div>
                            </div>

                            <?php if(!empty($books)): ?>

                                <div class="books_accordion">

                                    <?php foreach ($books as $book): ?>

                                        <?php
                                            $file = FileUpload::getFile($book->file, 'books', $book->id);
                                            $image = StaticFunctions::getImage($book->image, 'books', $book->id);
                                        ?>

                                        <div class="accordion_item">
                                            <div class="accordion_header">
                                                <div class="accordion_name">
                                                    <?=$book->name?>
                                                </div>
                                                <div class="accordion_author">
                                                    <?=$book->author?>
                                                </div>
                                                <div class="accordion_actions">
                                                    <ul class="actions">

                                                        <?php if (!empty($book->link)): ?>
                                                            <li>
                                                                <a href="<?=$book->link?>" class="action_link" target="_blank">
                                                                    <?=Yii::t('app', 'Buy')?> ↗
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>

                                                        <?php if (!empty($book->file)): ?>
                                                            <li>
                                                                <a href="<?=$file?>" class="action_link" target="_blank">
                                                                    <?=Yii::t('app', 'Download')?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>

                                                    </ul>
                                                    <button type="button" class="accordion_open" data-text-open="<?=Yii::t('app', 'Read less')?>" data-text-closed="<?=Yii::t('app', 'Read more')?>">
                                                        <?=Yii::t('app', 'Read more')?>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="accordion_content">
                                                <div class="content_row row">
                                                    <div class="col-xl-6 col-12">
                                                        <div class="accordion_texts">
                                                            <?=$book->description?>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-12">
                                                        <div class="accordion_image">
                                                            <img src="<?=$image?>" alt="<?=$book->name?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="research_articles" id="articles">
                            <h2 class="section_title">
                                <?=Yii::t('app', 'Articles')?>
                            </h2>
                            <?php if(!empty($articles)): ?>

                                <div class="articles_row row ">

                                    <?php foreach ($articles as $article): ?>

                                        <?php
                                        $preview = StaticFunctions::getThumbnail($article->image, 'articles', $article->id);

                                        $timestamp = strtotime($article->published_date);
                                        $lang = Yii::$app->language;
                                        $day = date('d', $timestamp);
                                        $monthNum = (int)date('n', $timestamp);
                                        $year = date('Y', $timestamp);

                                        $monthName = Yii::$app->params['months'][$lang][$monthNum] ?? date('F', $timestamp);
                                        ?>

                                        <div class="col-md-6 gy-lg-4 gy-3">
                                            <div class="article">
                                                <div class="article_image">
                                                    <img src="<?= $preview ?>" alt="<?= $article->title ?>">
                                                </div>
                                                <div class="article_date">
                                                    <?= $monthName . ' ' . $day . ', ' . $year ?>
                                                </div>
                                                <div class="article_title">
                                                    <?= $article->title ?>
                                                </div>
                                                <button type="button" class="article_link" data-id="<?= $article->id ?>">
                                                    <?= Yii::t('app', 'Read article') ?>
                                                </button>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>


                                </div>

                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="article_section"></div>

                </div>

            </section>

        <?php elseif ($section->name == 'archive'): ?>
            <section data-width="<?= $totalMenuWidth ?>" class="menu_bar <?= $section->name ?> <?= $section->is_opened == 1 ? 'opened' : '' ?> <?= $section->status == 0 ? 'disabled' : '' ?>"
                <?= $section->is_opened == 1 ? 'style="width: calc(100% - '.$totalMenuWidth.'px);"' : '' ?>>

                <div class="section_header">
                    <p class="first_title"><?=Yii::t('app', 'Archive')?></p>
                </div>
                <div class="main_section">
                    <div class="main_section_header">

                        <?=SectionLogo::widget()?>

                        <div class="header_navigation">
                            <ul>
                                <?php foreach ($years as $year): ?>
                                    <li>
                                        <button type="button"
                                                class="navigation_link<?= ($year == $activeYear) ? ' active' : '' ?>"
                                                data-year="<?= $year ?>">
                                            <?= $year ?>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>

                    <?php if(!empty($archive_hero)): ?>

                        <div class="section_content">
                            <div class="section_title">
                                <?=$archive_hero->title?>
                            </div>
                            <div class="section_description">
                                <?=$archive_hero->subtitle?>
                            </div>

                            <div class="archive_content">
                                <?=Html::decode($archive_hero->content)?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="archive_programs">
                        <div class="programs_title">
                            <?=Yii::t('app', 'summit_programme')?>
                        </div>

                        <div class="programs_accordion">
                            <?php foreach ($program_dates as $date): ?>
                                <?php
                                $timestamp = strtotime($date->date);
                                $day = date('j', $timestamp);
                                $month = Yii::$app->params['months'][Yii::$app->language][(int)date('n', $timestamp)];
                                $weekday = Yii::$app->params['weekdays'][Yii::$app->language][date('N', $timestamp)];

                                $daySessions = array_filter($sessions, fn($s) => $s->date_id === $date->id);
                                ?>

                                <div class="custom_accordion">
                                    <div class="accordion_date">
                                        <?= "{$day} {$month}, {$weekday}" ?>
                                    </div>

                                    <div class="accordion_item_wrapper">
                                        <?php foreach ($daySessions as $session): ?>
                                            <div class="programs_accordion__item">
                                                <div class="accordion_content">
                                                    <div class="accordion__title">
                                                        <?= Html::encode($session->title) ?>
                                                    </div>
                                                    <div class="accordion__body">
                                                        <?= $session->content ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>


                    </div>

                    <?php if(!empty($archive_news)): ?>

                        <div class="archive_news">
                            <div class="news_row">
                                <?php foreach ($archive_news as $news): ?>
                                    <?php $image = StaticFunctions::getImage($news->image, 'archive-news', $news->id) ?>

                                    <div class="archive_card">
                                        <div class="card_texts">
                                            <div class="card_title">
                                                <?=$news->title?>
                                            </div>
                                            <div class="card_description">
                                                <?=$news->description?>
                                            </div>
                                        </div>
                                        <div class="card_image">
                                            <img src="<?=$image?>" alt="<?=$news->title?>">
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        </div>

                    <?php endif; ?>


                    <?php if(!empty($archive_gallery)): ?>

                        <div class="gallery swiper mt-5">
                            <div class="swiper-wrapper">

                                <?php foreach ($archive_gallery->galleryItems as $item): ?>

                                    <?php $image = StaticFunctions::getImage($item->image, 'page-sections', $archive_gallery->id) ?>

                                    <div class="swiper-slide">
                                        <div class="slide_item">
                                            <img src="<?=$image?>" alt="">
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            </div>

                            <div class="swiper_navs">
                                <div class="slide_prev">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                                <div class="slide_next">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="partners archive">
                        <div class="partners_title">
                            <?=Yii::t('app', 'Aral Culture Summit Partners')?>
                        </div>
                        <?php if(!empty($partners)): ?>
                            <div class="partners_logo">
                                <?php foreach ($partners->galleryItems as $partner): ?>
                                    <?php $image = StaticFunctions::getImage($partner->image, 'page-sections', $partners->id) ?>
                                    <div class="partner_logo">
                                        <img src="<?=$image?>" alt="partner">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

            </section>

        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>






