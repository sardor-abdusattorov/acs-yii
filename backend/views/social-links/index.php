<?php

use common\models\SocialLinks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\SocialLinksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Социальные сети';
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
            'name',
            'class',
            'link',
            'order_by',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->status
                        ? Html::tag('span', 'Активен', ['class' => 'btn btn-success w-100 d-block'])
                        : Html::tag('span', 'Неактивен', ['class' => 'btn btn-danger w-100 d-block']);
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    [
                        1 => 'Активен',
                        0 => 'Неактивен',
                    ],
                    [
                        'class' => 'form-select',
                        'prompt' => 'Все статусы',
                    ]
                ),
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'class' => 'yii\\grid\\ActionColumn',
                'header' => 'Действия',
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{allButtons}',
                'buttons' => [
                    'allButtons' => function ($url, $model, $key) {
                        return Html::tag('div',
                            Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], ['class' => 'btn btn-info']) .
                            Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mx-1']) .
                            Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                'data-method' => 'post'
                            ]),
                            ['class' => 'd-flex align-items-center justify-content-center gap-1']
                        );
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
