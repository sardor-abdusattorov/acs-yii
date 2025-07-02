<?php

namespace frontend\widgets;

use yii\base\Widget;

class SectionLogo extends Widget
{
    public function run()
    {
        return $this->render('section-logo');
    }
}