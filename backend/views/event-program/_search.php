<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EventProgramSearch $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="card card-primary card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
                ]); ?>

            <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'day') ?>

    <?= $form->field($model, 'start_time') ?>

    <?= $form->field($model, 'tag_id') ?>

    <?= $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'location_id') ?>

    <?php // echo $form->field($model, 'bg_color') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'order_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
