<?php


use common\components\StaticFunctions;
use frontend\widgets\SectionLogo;
use yii\helpers\Html;

?>

<div class="section_header">
    <p class="first_title">
        <?=Yii::t('app', 'Programme')?>
    </p>
</div>

<div class="main_section">
    <div class="main_section_header">

        <?= SectionLogo::widget()?>

        <div class="header_navigation">
            <ul>
                <li>
                    <a href="#partners" class="navigation_link scroll-link">
                        <?=Yii::t('app', 'Partners')?>
                    </a>
                </li>
                <li>
                    <a href="#press" class="navigation_link scroll-link">
                        <?=Yii::t('app', 'Press Selection')?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main_section_content">
        <?php if(!empty($section)): ?>

            <div class="section_title">
                <?=$section->title?>
            </div>

            <div class="section_subtitle">
                <?=$section->subtitle?>
            </div>


        <?php endif; ?>


        <div class="reg_button_container">
            <button class="reg_button" data-bs-toggle="modal" data-bs-target="#registerModal"><?=Yii::t('app', 'Register now')?> ↘</button>
        </div>
    </div>

    <div class="main_section_hero">
        <div class="container-fluid">
            <div class="full_program_container" id="press">
                <div class="full_program_header">
                    <div class="full_program_title">
                        <p><?= Yii::t('app', 'When') ?></p>
                    </div>
                    <div class="event_days">
                        <div class="row">
                            <?php
                            $months = Yii::$app->params['months'][Yii::$app->language] ?? [];
                            foreach ($days as $index => $day):
                                $timestamp = strtotime($day);
                                $dayNum = date('j', $timestamp);
                                $monthNum = date('n', $timestamp);
                                $monthName = $months[$monthNum] ?? date('F', $timestamp);

                                $activeClass = ($index === 0) ? 'active' : '';
                                ?>
                                <div class="col-4 pl-0">
                                    <button
                                            type="button"
                                            class="event_day w-100 <?= $activeClass ?>"
                                            data-day="<?= $day ?>"
                                    >
                                        <?= $dayNum . ' ' . $monthName ?>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>

                <div class="events">
                    <?php if (!empty($firstDayPrograms)): ?>
                        <div class="events_container">
                            <?php foreach ($firstDayPrograms as $program): ?>
                                <div class="row mb-3">
                                    <div class="col-12 col-lg-3 pl-0 pr-0 pr-md-2">
                                        <div class="event_time_location p-2 p-md-4">
                                            <p class="event_time">
                                                <?= Yii::$app->formatter->asTime($program->start_time, 'php:H:i') ?> - <?= Yii::$app->formatter->asTime($program->end_time, 'php:H:i') ?>
                                            </p>
                                            <p class="event_location">
                                                <?= Html::encode($program->location->title) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 pr-0 pl-0 pl-md-2">
                                        <div class="event_data" style="background-color: <?= Html::encode($program->bg_color ?: '#f3fff4') ?>">
                                            <div class="event p-2 p-md-4">
                                                <div class="event_type mb-3 d-flex">
                                                <span class="event_type_title">
                                                    <?= Html::encode($program->tag->title)?>
                                                </span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 mb-2 mb-lg-0">
                                                        <h3 class="event_title">
                                                            <?= Html::decode($program->title) ?>
                                                        </h3>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="event_description">
                                                            <?= Html::decode($program->description) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="master_class">
                    <div class="row">
                        <div class="col-12 col-lg-3 pl-0 pr-0 pr-md-2">
                            <div class="title">
                                <?=Yii::t('app', 'Masterclasses and market last from 11:00 to 16:30')?>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9 pr-0 pl-0 pl-md-2">
                            <div class="description">
                                <?=Yii::t('app', 'Masterclasses and market')?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="partners" id="partners">
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

                <div class="partner_texts row">
                    <?php if(!empty($partners_left)): ?>
                        <div class="col-12 col-lg-6 mb-3 mb-md-0">
                            <div class="partners_text">
                                <h2>
                                    <?=$partners_left->title?>
                                </h2>
                                <?=$partners_left->content?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($partners_right)): ?>
                        <div class="col-12 col-lg-6 mb-3 mb-md-0">
                            <div class="partners_text">
                                <h2>
                                    <?=$partners_right->title?>
                                </h2>
                                <?=$partners_right->content?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="partners_action">
                    <div class="action_title">
                        <?=Yii::t('app', 'Click to download the press kit')?>
                    </div>
                    <div class="download_button">
                        <a href="#" class="download_btn">
                            <?=Yii::t('app', 'Press kit')?>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
