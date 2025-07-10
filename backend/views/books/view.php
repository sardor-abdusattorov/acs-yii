<?php

use common\components\FileUpload;
use common\components\StaticFunctions;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Books $model */

$this->title = $model->translate(Yii::$app->language)->name ?? $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
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
                'label' => 'Автор (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $title = $model->translate($lang)->author ?? '<i>Не указано</i>';
                        $output .= "<strong>{$label}:</strong> " . Html::decode($title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'label' => 'Название (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $title = $model->translate($lang)->name ?? '<i>Не указано</i>';
                        $output .= "<strong>{$label}:</strong> " . Html::decode($title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'label' => 'Описание (переводы)',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach (Yii::$app->params['languages'] as $lang => $label) {
                        $title = $model->translate($lang)->description ?? '<i>Не указано</i>';
                        $output .= "<strong>{$label}:</strong> " . Html::decode($title) . '<br>';
                    }
                    return $output;
                }
            ],
            [
                'attribute'=>'image',
                'value'=>function($data){
                    $image = StaticFunctions::getImage($data->image,'books',$data->id);
                    return "<img src='$image' style='max-height: 150px' alt='<?=$data->image?>'>";
                },
                'format'=>"html"
            ],
            [
                'label' => 'Файл',
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->file) {
                        $url = FileUpload::getFile($model->file, 'books', $model->id);
                        if ($url) {
                            $basename = basename($model->file);
                            return Html::a('Скачать файл', $url, ['target' => '_blank', 'download' => $basename]);
                        } else {
                            return '<i>Файл не найден</i>';
                        }
                    }
                    return '<i>Нет файла</i>';
                }
            ],

            'link',
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
