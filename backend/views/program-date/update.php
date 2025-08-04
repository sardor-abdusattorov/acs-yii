<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProgramDate $model */

$this->title = 'Редактировать: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Даты программы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </div>
</div>
