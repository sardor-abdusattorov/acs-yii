<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\ProgramSessions $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Сессии программы', 'url' => ['index']];
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
                'label' => 'Заголовок (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $title = $model->translate($lang)->title ?? '<i>Не указано</i>';
                        $output .= "<strong>{$label}:</strong> " . Html::decode($title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'label' => 'Контент (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $title = $model->translate($lang)->content ?? '<i>Не указано</i>';
                        $output .= "<strong>{$label}:</strong> " . Html::decode($title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'attribute' => 'date_id',
                'label' => 'Дата',
                'value' => function($model) {
                    return $model->date->date ?? '(не задано)';
                }
            ],

            'sort',
            'created_at',
            'updated_at',
        ],
        ]) ?>
    </div>
</div>
