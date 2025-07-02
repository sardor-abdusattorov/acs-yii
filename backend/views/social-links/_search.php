<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SocialLinksSearch $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="card card-primary card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
                ]); ?>

            <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'class') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'order_by') ?>

    <?php // echo $form->field($model, 'status') ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
