<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Pages $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h2 class="mb-3"><?= Html::encode($this->title) ?></h2>
        <div class="d-flex align-items-center gap-2">
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if (Yii::$app->user->can('delete page')): ?>
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
            [
                'label' => 'Название (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $title = $model->translate($lang)->title ?? 'Не указано';
                        $output .= "<strong>{$label}:</strong> " . Html::encode($title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'label' => 'Мета название (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $meta_title = $model->translate($lang)->meta_title ?? 'Не указано';
                        $output .= "<strong>{$label}:</strong> " . Html::encode($meta_title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'label' => 'Мета описание (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $meta_description = $model->translate($lang)->meta_description ?? 'Не указано';
                        $output .= "<strong>{$label}:</strong> " . Html::encode($meta_description) . '<br>';
                    }
                    return $output;
                }
            ],
            'name',
            'slug',
            'created_at',
            'updated_at',
        ],
        ]) ?>
    </div>
</div>
