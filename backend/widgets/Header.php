<?php

namespace backend\widgets;

use common\models\User;
use Yii;
use yii\base\Widget;

class Header extends Widget
{
    public function run()
    {
        $userId = Yii::$app->user->id;
        $user = User::getUserById($userId);

        return $this->render('header', [
            'user' => $user,
        ]);
    }
}