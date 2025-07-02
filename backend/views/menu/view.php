<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Menu $model */

$this->title = $model->translate(Yii::$app->language)->title ?? $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex align-items-center gap-2">
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if (Yii::$app->user->can('delete menu')): ?>
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
                            $title = $model->translate($lang)->title ?? '<i>Не указано</i>';
                            $output .= "<strong>{$label}:</strong> " . Html::encode($title) . '<br>';
                        }
                        return $output;
                    }
                ],
                'link',
                [
                    'attribute' => 'position',
                    'value' => Yii::$app->params['menu_positions'][$model->position] ?? $model->position,
                ],
                [
                    'attribute' => 'parent_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->parent) {
                            $title = $model->parent->translate('ru')->title ?? ('ID: ' . $model->parent_id);
                            return Html::a($title, ['view', 'id' => $model->parent_id]);
                        }
                        return null;
                    }
                ],

                'order_by',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => $model->status == 1
                        ? '<span class="btn btn-success">Активный</span>'
                        : '<span class="btn btn-secondary">Неактивный</span>',
                ],
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>
</div>
