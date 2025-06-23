<?php

use common\components\StaticFunctions;
use mdm\admin\models\form\Signup;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model Signup */
/* @var $departments array */
/* @var $positionsData array */

?>

<?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-sm-8">
        <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'full_name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'retypePassword')->passwordInput() ?>
    </div>

    <div class="col-sm-4">
        <label class="d-flex align-items-center flex-column mb-3 w-100">
            <?php $image = StaticFunctions::getImage($model->avatar, 'user', $model->id) ?>
            <img src="<?=$image?>" alt="no photo" style="max-width: 100%; height: 200px">
            <?= $form->field($model, 'avatar')->fileInput(['hidden'=>true, 'class'=>'preview'])->label(false) ?>
            <div class="btn btn-primary w-100">Загрузить изображение</div>
        </label>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton(Yii::t('rbac-admin', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
</div>
<?php ActiveForm::end(); ?>
