<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SourceMessage $model */

$this->title = 'Добавить Source Message';
$this->params['breadcrumbs'][] = ['label' => 'Source Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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