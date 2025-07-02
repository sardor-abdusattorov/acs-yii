<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Tags $model */

$this->title = $model->translate(Yii::$app->language)->title ?? $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Тэги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
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
                'attribute' => 'status',
                'format' => 'html',
                'value' => $model->status == 1
                    ? '<span class="btn btn-success">Активный</span>'
                    : '<span class="btn btn-secondary">Неактивный</span>',
            ],
            'order_by',
            'created_at',
            'updated_at',
        ],
        ]) ?>
    </div>
</div>
