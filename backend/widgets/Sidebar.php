<?php

namespace backend\widgets;

use yii\base\Widget;
use Yii;
use common\models\User;

class Sidebar extends Widget
{
    public function run()
    {
        $userId = Yii::$app->user->id;
        $user = User::getUserById($userId);
        return $this->render('sidebar', [
            'user' => $user,
        ]);
    }
}
