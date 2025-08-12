<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SocialLinks $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Социальные сети', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
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
            'name',
            'class',
            'link',
            'order_by',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->status
                        ? Html::tag('span', 'Активен', ['class' => 'btn btn-success'])
                        : Html::tag('span', 'Неактивен', ['class' => 'btn btn-warning']);
                },
            ],
            'created_at',
            'updated_at',
        ],
        ]) ?>
    </div>
</div>
