<?php

namespace frontend\widgets;

use yii\base\Widget;

class Program extends Widget
{
    public function run()
    {
        return $this->render('program');
    }
}