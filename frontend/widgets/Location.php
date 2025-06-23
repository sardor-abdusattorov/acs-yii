<?php

namespace frontend\widgets;

use yii\base\Widget;

class Location extends Widget
{
    public function run()
    {
        return $this->render('location');
    }
}