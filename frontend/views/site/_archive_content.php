<?php use common\components\StaticFunctions;
use frontend\widgets\SectionLogo;
use yii\helpers\Html;


?>

<div class="main_section_header">

    <?=SectionLogo::widget()?>

    <div class="header_navigation">
        <ul>
            <?php foreach ($years as $year): ?>
                <button type="button"
                        class="navigation_link<?= ($year == $activeYear) ? ' active' : '' ?>"
                        data-year="<?= $year ?>">
                    <?= $year ?>
                </button>
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