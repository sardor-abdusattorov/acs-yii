<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SourceMessage $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Source Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex align-items-center gap-2">
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
            'method' => 'post',
            ],
            ]) ?>
        </div>
    </div>
    <div class="card-body">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                    'id',
            'category',
            'message:ntext',
        ],
        ]) ?>
    </div>
</div>
