<?php

namespace frontend\widgets;

use common\models\Locations;
use common\models\PageSections;
use yii\base\Widget;

class Location extends Widget
{
    public function run()
    {
        $locations = Locations::find()->where(['status' => 1])  ->orderBy(['order_by' => SORT_ASC])->all();
        $section = PageSections::find()->where(['name' => 'location_header'])->one();
        $gallery = PageSections::find()->where(['name' => 'location_gallery'])->with('galleryItems')->one();

        return $this->render('location',
        [
            'locations' => $locations,
            'section' => $section,
            'gallery' => $gallery,
        ]);
    }
}