<?php

namespace frontend\widgets;

use yii\base\Widget;

class Archive extends Widget
{
    public function run()
    {
        return $this->render('archive');
    }
}