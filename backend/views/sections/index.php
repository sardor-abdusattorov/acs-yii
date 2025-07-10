<?php

use common\models\Sections;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\SectionsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Секции';
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
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover align-middle text-center mt-2 table-responsive'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',

                [
                    'attribute' => 'is_opened',
                    'format' => 'html',
                    'filter' => [0 => 'Нет', 1 => 'Да'],
                    'value' => function (Sections $model) {
                        return $model->is_opened
                            ? '<span class="badge bg-success">Да</span>'
                            : '<span class="badge bg-secondary">Нет</span>';
                    },
                ],

                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'filter' => [0 => 'Неактивен', 1 => 'Активен'],
                    'value' => function (Sections $model) {
                        return $model->status
                            ? '<span class="badge bg-success">Активен</span>'
                            : '<span class="badge bg-danger">Неактивен</span>';
                    },
                ],

                [
                    'attribute' => 'created_at',
                    'format' => ['datetime', 'php:d.m.Y H:i'],
                ],

                [
                    'class' => ActionColumn::class,
                    'header' => 'Действия',
                    'contentOptions' => ['class' => 'text-center'],
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url) {
                            return Html::a('<i class="fas fa-eye"></i>', $url, [
                                'class' => 'btn btn-sm btn-info mx-1',
                                'title' => 'Просмотр'
                            ]);
                        },
                        'update' => function ($url) {
                            return Html::a('<i class="fas fa-edit"></i>', $url, [
                                'class' => 'btn btn-sm btn-primary mx-1',
                                'title' => 'Редактировать'
                            ]);
                        },
                        'delete' => function ($url, $model, $key) {
                            if (Yii::$app->user->can('delete section')) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'class' => 'btn btn-sm btn-danger mx-1',
                                    'title' => 'Удалить',
                                    'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                    'data-method' => 'post',
                                ]);
                            }
                            return '';
                        },
                    ],
                ],

            ],
            'layout' => "{items}\n<div class=\"d-flex justify-content-center mt-3\">{pager}</div>",
            'pager' => [
                'class' => LinkPager::class,
                'prevPageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item',
                'options' => ['class' => 'pagination'],
                'linkOptions' => ['class' => 'page-link'],
            ],
        ]); ?>
    </div>
</div>
