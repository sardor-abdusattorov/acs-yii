<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Sections $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Секции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h2 class="mb-3"><?= Html::encode($this->title) ?></h2>
        <div class="d-flex align-items-center gap-2">
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if (Yii::$app->user->can('delete section')): ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                [
                    'attribute' => 'is_opened',
                    'format' => 'html',
                    'value' => $model->is_opened
                        ? '<span class="badge bg-success">Да</span>'
                        : '<span class="badge bg-secondary">Нет</span>',
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => $model->status
                        ? '<span class="badge bg-success">Активен</span>'
                        : '<span class="badge bg-danger">Неактивен</span>',
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['datetime', 'php:d.m.Y H:i'],
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['datetime', 'php:d.m.Y H:i'],
                ],
            ],
        ]) ?>
    </div>
</div>
