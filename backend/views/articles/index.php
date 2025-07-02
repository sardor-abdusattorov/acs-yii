<?php

use common\components\StaticFunctions;
use common\models\Articles;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ArticlesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h3 class="d-inline"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="card-body">
                            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'mt-2 text-center table table-striped table-bordered align-middle'],
            'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'contentOptions' => ['class' => 'align-middle'],
            ],

//            'id',
            [
                'attribute' => 'title',
                'label' => 'Заголовок',
                'value' => function ($model) {
                    return $model->translate(Yii::$app->language)->title ?? '(не задано)';
                },
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'attribute' => 'image',
                'value' => function($data) {
                    $image = StaticFunctions::getImage($data->image, 'articles', $data->id);
                    return "<img src='$image' style='max-width: 150px' alt='" . $data->image . "'>";
                },
                'format' => "html"
            ],
//            'slug',
//            'order_by',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    switch ($model->status) {
                        case Articles::STATUS_ACTIVE:
                            return Html::tag('span', 'Активен', ['class' => 'btn btn-success w-100 d-block']);
                        case Articles::STATUS_INACTIVE:
                            return Html::tag('span', 'Неактивен', ['class' => 'btn btn-secondary w-100 d-block']);
                        case Articles::STATUS_ARCHIVED:
                            return Html::tag('span', 'Архив', ['class' => 'btn btn-warning w-100 d-block']);
                        default:
                            return Html::tag('span', 'Неизвестно', ['class' => 'btn btn-light w-100 d-block']);
                    }
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Articles::getStatusList(),
                    [
                        'class' => 'form-select',
                        'prompt' => 'Все статусы',
                    ]
                ),
                'contentOptions' => ['class' => 'align-middle'],
            ],
            'created_at',
            //'updated_at',
            [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
            'contentOptions' => ['class' => 'text-center'],
            'buttons' => [
            'view' => function ($url) {
            return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-info']);
            },
            'update' => function ($url) {
            return Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-primary']);
            },
            'delete' => function ($url) {
            return Html::a('<i class="fas fa-trash"></i>', $url, [
            'class' => 'btn btn-danger mx-1',
            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
            'data-method' => 'post'
            ]);
            },
            ],
            ]
            ],
            'layout' => "{items}\n<div class=\"d-flex justify-content-center\">{pager}</div>",
            'pager' => [
            'class' => 'yii\bootstrap5\LinkPager',
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
            'linkOptions' => ['class' => 'page-link'],
            ],
            ]); ?>
        
            </div>
</div>
