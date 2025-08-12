<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\RegistrationSearch $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="card card-primary card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
                ]); ?>

            <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'postal_code') ?>

    <?php // echo $form->field($model, 'sources') ?>

    <?php // echo $form->field($model, 'attendance_days') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
