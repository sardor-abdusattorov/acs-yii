<?php

use common\models\EventProgram;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\EventProgram $model */

$this->title = $model->translate(Yii::$app->language)->title ?? $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Программа мероприятий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h2 class="mb-3"><?= Html::encode($this->title) ?></h2>
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
            [
                'label' => 'Название (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $title = $model->translate($lang)->title ?? '<i>Не указано</i>';
                        $output .= "<strong>{$label}:</strong> " . Html::encode($title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'label' => 'Описание',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $excerpt = $model->translate($lang)->description ?? 'Не указано';
                        $output .= "<strong>{$label}:</strong> " . Html::decode($excerpt) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'label' => 'Контент',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $content = $model->translate($lang)->content ?? 'Не указано';
                        $output .= "<strong>{$label}:</strong> " . Html::decode($content) . '<br>';
                    }
                    return $output;
                }
            ],
            'day',
            'start_time',
            [
                'attribute' => 'tag_id',
                'label' => 'Тэг',
                'value' => $model->tag->title ?? '(не указано)',
            ],
            'end_time',
            [
                'attribute' => 'location_id',
                'label' => 'Тэг',
                'value' => $model->location->title ?? '(не указано)',
            ],
            [
                'attribute' => 'bg_color',
                'format' => 'raw',
                'value' => Html::tag('span', $model->bg_color, [
                    'style' => "background-color: {$model->bg_color}; color: #ccc; padding: 4px 8px; border-radius: 4px;"
                ]),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    switch ($model->status) {
                        case EventProgram::STATUS_ACTIVE:
                            return '<span class="btn btn-success">Активный</span>';
                        case EventProgram::STATUS_INACTIVE:
                            return '<span class="btn btn-secondary">Неактивный</span>';
                        case EventProgram::STATUS_ARCHIVED:
                            return '<span class="btn btn-warning">Архив</span>';
                        default:
                            return '<span class="btn btn-light">Неизвестно</span>';
                    }
                },
            ],
            'order_by',
            'created_at',
            'updated_at',
        ],
        ]) ?>
    </div>
</div>
