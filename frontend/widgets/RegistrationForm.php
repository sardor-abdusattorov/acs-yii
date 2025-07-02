<?php

namespace frontend\widgets;

use common\models\Registration;
use yii\base\Widget;

class RegistrationForm extends Widget
{
    public function run()
    {
        $model = new Registration();
        return $this->render('registration-form', [
            'model' => $model,
        ]);
    }
}