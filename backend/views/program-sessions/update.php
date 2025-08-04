<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProgramSessions $model */

$this->title = 'Редактировать: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Сессии программы', 'url' => ['index']];
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
            'dates' => $dates,
        ]) ?>
    </div>
</div>
