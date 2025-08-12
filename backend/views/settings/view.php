<?php

use common\components\StaticFunctions;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Settings $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки значений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h2 class="mb-3"><?= Html::encode($this->title) ?></h2>
        <div class="d-flex align-items-center gap-2">
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if (Yii::$app->user->can('delete settings')): ?>
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
            'value:ntext',
            [
                'label' => 'Значение (перевод)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $value = $model->translate($lang)->value ?? 'Не указано';
                        $output .= "<strong>{$label}:</strong> " . Html::encode($value) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'attribute'=>'image',
                'value'=>function($data){
                    $image = StaticFunctions::getImage($data->image, 'settings', $data->id);
                    return "<img src='$image' style='max-height: 150px' alt='<?=$data->image?>'>";
                },
                'format'=>"html"
            ],
            [
                'attribute' => 'is_translatable',
                'format' => 'html',
                'value' => $model->is_translatable == 1
                    ? '<span class="btn btn-success">Переводится</span>'
                    : '<span class="btn btn-secondary">Не переводится</span>',
            ],
            'created_at',
            'updated_at',
        ],
        ]) ?>
    </div>
</div>
