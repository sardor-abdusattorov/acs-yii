<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\BooksSearch $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="card card-primary card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
                ]); ?>

            <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'file') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'status') ?>

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
