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
        <?php if ($section->name == 'hero'): ?>
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
                            <div class="languages ml-4 ml-lg-0 mt-lg-4 py-4 py-lg-0 my-md-0 d-flex text-center">
                                <?php foreach ($languages as $code => $label): ?>
                                    <a rel="alternate" hreflang="<?= strtoupper($code) ?>" href="<?= Url::current(['language' => $code]) ?>" class="d-block <?= $code === $language ? 'active' : '' ?>">
                                        <?= strtoupper($code) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
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

                                        $timestamp = strtotime($article->created_at);
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

                        <?php $image = StaticFunctions::getImage($archive_hero->image, 'page-sections', $archive_hero->id) ?>
                        <div class="section_content">
                            <div class="section_title">
                                <?=$archive_hero->title?>
                            </div>
                            <div class="section_image">
                                <a href="<?= $image ?>" class="w-100" data-fancybox="gallery" data-caption="<?= htmlspecialchars($archive_hero->title, ENT_QUOTES) ?>">
                                    <img src="<?= $image ?>" alt="<?= htmlspecialchars($archive_hero->title, ENT_QUOTES) ?>">
                                </a>
                            </div>

                            <div class="archive_content">
                                <?=$archive_hero->content?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if (!empty($archive_events) && !empty($tags)): ?>
                        <div class="archive_articles">
                            <?php foreach ($tags as $tag): ?>
                                <?php
                                $tagEvents = array_filter($archive_events, function($event) use ($tag) {
                                    return $event->tag_id == $tag->id;
                                });
                                ?>

                                <?php if (!empty($tagEvents)): ?>
                                    <div class="archive_block">
                                        <div class="block_title">
                                            <?= Html::encode($tag->title) ?>
                                        </div>
                                        <div class="archives">
                                            <?php foreach ($tagEvents as $event): ?>
                                                <div class="archive">
                                                    <button type="button" class="archive_name" data-id="<?= $event->id ?>">
                                                        <?= Html::encode($event->title) ?>
                                                    </button>
                                                    <div class="archive_type">
                                                        <?= Html::encode($event->tag->title) ?>
                                                    </div>
                                                    <div class="archive_time">
                                                        <?= Yii::$app->formatter->asTime($event->start_time, 'php:H:i') ?> - <?= Yii::$app->formatter->asTime($event->end_time, 'php:H:i') ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>


                    <div class="locations_archive">
                        <div class="section_title">
                            <?=Yii::t('app', 'Locations')?>
                        </div>
                        <?php if(!empty($old_locations)): ?>

                            <div class="locations_row">

                                <?php foreach ($old_locations as $location): ?>

                                    <?php $image = StaticFunctions::getImage($location->image, 'locations', $location->id) ?>

                                    <div class="row archive_location">
                                        <div class="col-xl-6 col-12">
                                            <div class="location_content">
                                                <div class="location_name">
                                                    <?=$location->title?>
                                                </div>
                                                <div class="location_details">
                                                    <?=$location->content?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-12">
                                            <div class="location_image">
                                                <img src="<?=$image?>" alt="<?=$location->title?>">
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            </div>

                        <?php endif; ?>

                    </div>

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

                    <div class="archive_article">
                        <div class="article_title">
                            Charting Water Futures
                        </div>
                        <div class="article_description">
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore meat
                            agna aliquam erat volutpat. Ut wisi enim ad minim veniam,
                            quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet doloresun magna aliquam erat volutpat.
                        </div>
                        <div class="article_infos">
                            <div class="info_item">
                                <div class="inner_item">
                                    <div class="info_title">
                                        4TH OF APRIL
                                    </div>
                                    <div class="info_description fw-bolder">
                                        11:00 – 12:00
                                    </div>
                                </div>
                            </div>
                            <div class="info_item">
                                <div class="inner_item">
                                    <div class="info_title">
                                        ATTENDEES
                                    </div>
                                    <div class="info_description">

                                    </div>
                                </div>
                            </div>
                            <div class="info_item">
                                <div class="inner_item">
                                    <div class="info_title">
                                        NABI AGZAMOV
                                    </div>
                                    <div class="info_description">
                                        Architect, Researcher at 5th Studio, Uzbekistan/Great Britain
                                    </div>
                                </div>
                                <div class="inner_item">
                                    <div class="info_title">
                                        AHMED AND RASHID BIN SHABIB
                                    </div>
                                    <div class="info_description">
                                        Founders of Brownbook and architects of interdisciplinary projects rethinking the circulation of materials and ideas in urbanism
                                    </div>
                                </div>
                                <div class="inner_item">
                                    <div class="info_title">
                                        VLADIM SOKOLOV
                                    </div>
                                    <div class="info_description">
                                        Head of the Project Implementation Agency of the International Fund for Saving the Aral Sea (IFAS), Uzbekistan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="article_texts">
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisiimi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolorm
                                in hendrerit in vulputate velit esse molstie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonum. Loremim ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh eui Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wismi enim ad minim veniam, quis nostrudi exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan
                                et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisiimi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolorm
                                in hendrerit in vulputate velit esse molstie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonum. Loremim ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh eui Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wismi enim ad minim veniam, quis nostrudi exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan
                                et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat
                            </p>
                        </div>
                        <div class="gallery swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="slide_item">
                                        <img src="/images/location_1.png" alt="">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="slide_item">
                                        <img src="/images/location_1.png" alt="">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="slide_item">
                                        <img src="/images/location_1.png" alt="">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="slide_item">
                                        <img src="/images/location_1.png" alt="">
                                    </div>
                                </div>
                            </div>

                            <!-- Навигационные кнопки -->
                            <div class="swiper_navs">
                                <div class="slide_prev">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                                <div class="slide_next">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>






