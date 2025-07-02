<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PageSections $model */

$this->title = 'Редактировать: ' . $model->translate(Yii::$app->language)->title ?? $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Секции страниц', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->translate(Yii::$app->language)->title ?? $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
            'pages' => $pages,
        ]) ?>
    </div>
</div>
