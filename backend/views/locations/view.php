<?php

use common\components\StaticFunctions;
use common\models\Locations;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Locations $model */

$this->title = $model->translate(Yii::$app->language)->title ?? $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Локации', 'url' => ['index']];
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
                'label' => 'Заголовок',
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
            [
                'attribute'=>'image',
                'value'=>function($data){
                    $image = StaticFunctions::getImage($data->image,'locations',$data->id);
                    return "<img src='$image' style='max-height: 150px' alt='<?=$data->image?>'>";
                },
                'format'=>"html"
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    switch ($model->status) {
                        case Locations::STATUS_ACTIVE:
                            return '<span class="btn btn-success">Активный</span>';
                        case Locations::STATUS_INACTIVE:
                            return '<span class="btn btn-secondary">Неактивный</span>';
                        case Locations::STATUS_ARCHIVED:
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
