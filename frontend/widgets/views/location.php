<?php

use common\components\StaticFunctions;
use frontend\widgets\SectionLogo;


?>
<div class="section_header">
    <p class="first_title"><?=Yii::t('app', 'Location')?></p>
</div>

<div class="main_section">
    <div class="main_section_header">

        <?= SectionLogo::widget()?>

        <div class="header_navigation">
            <ul>
                <?php if(!empty($locations)): ?>
                    <?php foreach ($locations as $location): ?>
                        <li>
                            <a href="#<?=$location->name?>" class="navigation_link scroll-link">
                                <?=$location->title?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
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

        <div class="locations_row">

            <?php if(!empty($locations)): ?>
                <?php foreach ($locations as $location): ?>
                    <div class="location_item" id="<?=$location->name?>">
                        <div class="location_name">
                            <?=$location->title?>
                        </div>
                        <div class="location_content">
                            <?=$location->content?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <?php if(!empty($gallery)): ?>

            <div class="gallery swiper mt-5">
                <div class="swiper-wrapper">
                    <?php foreach ($gallery->galleryItems as $item): ?>

                        <?php $image = StaticFunctions::getImage($item->image, 'page-sections', $gallery->id) ?>

                        <div class="swiper-slide">
                            <div class="slide_item">
                                <img src="<?=$image?>" alt="">
                            </div>
                        </div>

                    <?php endforeach; ?>

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

        <?php endif; ?>

    </div>
</div>