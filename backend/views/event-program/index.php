<?php

use common\models\EventProgram;
use common\models\Locations;
use common\models\Tags;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\EventProgramSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Программа мероприятий';
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
//            'day',
            [
                'attribute' => 'title',
                'label' => 'Заголовок',
                'value' => function ($model) {
                    return $model->translate(Yii::$app->language)->title ?? '(не задано)';
                },
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'attribute' => 'location_id',
                'format' => 'raw',
                'label' => 'Локация',
                'value' => function ($model) {
                    return $model->location ? $model->location->translate(Yii::$app->language)->title : '(не задано)';
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'location_id',
                    'data' => Locations::getDropdownList(),
                    'options' => ['placeholder' => 'Все локации'],
                    'pluginOptions' => ['allowClear' => true],
                ]),
            ],
            [
                'attribute' => 'tag_id',
                'format' => 'raw',
                'label' => 'Тег',
                'value' => function ($model) {
                    return $model->tag ? $model->tag->translate(Yii::$app->language)->title : '(не задано)';
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'tag_id',
                    'data' => Tags::getDropdownList(),
                    'options' => ['placeholder' => 'Все теги'],
                    'pluginOptions' => ['allowClear' => true],
                ]),
            ],
//            'start_time',
//            'end_time',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    switch ($model->status) {
                        case EventProgram::STATUS_ACTIVE:
                            return Html::tag('span', 'Активен', ['class' => 'btn btn-success w-100 d-block']);
                        case EventProgram::STATUS_INACTIVE:
                            return Html::tag('span', 'Неактивен', ['class' => 'btn btn-secondary w-100 d-block']);
                        case EventProgram::STATUS_ARCHIVED:
                            return Html::tag('span', 'Архив', ['class' => 'btn btn-warning w-100 d-block']);
                        default:
                            return Html::tag('span', 'Неизвестно', ['class' => 'btn btn-light w-100 d-block']);
                    }
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    EventProgram::getStatusList(),
                    [
                        'class' => 'form-select',
                        'prompt' => 'Все статусы',
                    ]
                ),
                'contentOptions' => ['class' => 'align-middle'],
            ],
            //'bg_color',
            //'order_by',
            //'created_at',
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
