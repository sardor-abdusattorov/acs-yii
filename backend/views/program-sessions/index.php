<?php

use common\models\ProgramSessions;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ProgramSessionsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Сессии программы';
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
            'tableOptions' => ['class' => 'mt-2 text-center table table-striped table-bordered align-middle table-responsive'],
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
                'attribute' => 'date_id',
                'label' => 'Дата',
                'value' => function ($model) {
                    return $model->date->date ?? '(не задано)';
                },
                'contentOptions' => ['class' => 'align-middle'],
            ],

            'sort',
            'created_at',
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
