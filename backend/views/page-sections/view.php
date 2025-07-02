<?php

use common\components\StaticFunctions;
use common\models\GalleryItems;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PageSections $model */

$this->title = $model->translate(Yii::$app->language)->title ?? $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Секции страниц', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h2 class="mb-3"><?= Html::encode($this->title) ?></h2>
        <div class="d-flex align-items-center gap-2">
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if (Yii::$app->user->can('delete page-section')): ?>
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
                'label' => 'Заголовок',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $title = $model->translate($lang)->title ?? 'Не указано';
                        $output .= "<strong>{$label}:</strong> " . Html::decode($title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'label' => 'Подзаголовок',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $excerpt = $model->translate($lang)->subtitle ?? 'Не указано';
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
            [
                'label' => 'Страница',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->page) {
                        return Html::a(
                            Html::encode($model->page->name),
                            ['pages/view', 'id' => $model->page_id],
                            ['target' => '_blank']
                        );
                    }
                    return '(не указано)';
                }
            ],
            [
                'label' => 'Галерея изображений',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    $gallery = GalleryItems::find()
                        ->where(['section_id' => $model->id])
                        ->all();

                    foreach ($gallery as $item) {
                        $img = StaticFunctions::getImage($item->image, 'page-sections', $model->id);
                        $output .= Html::img($img, ['style' => 'height: 100px; margin: 5px; border: 1px solid #ddd']);
                    }

                    return $output ?: '(нет изображений)';
                }
            ],
            [
                'attribute'=>'image',
                'value'=>function($data){
                    $image = StaticFunctions::getImage($data->image,'page-sections',$data->id);
                    return "<img src='$image' style='max-height: 150px' alt='<?=$data->image?>'>";
                },
                'format'=>"html"
            ],
            'sort',
            'created_at',
            'updated_at',
        ],
        ]) ?>
    </div>
</div>
