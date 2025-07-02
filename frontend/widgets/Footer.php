<?php

namespace frontend\widgets;

use common\models\Menu;
use common\models\Settings;
use common\models\SocialLinks;
use common\models\Subscribers;
use yii\base\Widget;

class Footer extends Widget
{
    public function run()
    {
        $subscribers = new Subscribers();

        $menus = Menu::find()
            ->where(['status' => 1, 'position' => 2])
            ->orderBy(['order_by' => SORT_ASC])
            ->all();

        $settings = Settings::getValues([
            'acdf',
            'acdf_address',
            'acdf_phone',
            'acdf_email',
        ]);

        $social_links = SocialLinks::find()->where(['status' => 1])->orderBy(['order_by' => SORT_ASC])->all();

        return $this->render('footer', [
            'subscribers' => $subscribers,
            'menus' => $menus,
            'settings' => $settings,
            'social_links' => $social_links,
        ]);
    }
}
