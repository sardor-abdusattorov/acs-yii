<?php

use common\components\StaticFunctions;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\SettingsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Настройки значений';
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
            'value',
            [
                'attribute' => 'image',
                'value' => function($data) {
                    $image = StaticFunctions::getImage($data->image, 'settings', $data->id);
                    return "<img src='$image' style='max-width: 150px' alt='" . $data->image . "'>";
                },
                'format' => "html"
            ],
            [
                'attribute' => 'is_translatable',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->is_translatable
                        ? Html::tag('span', 'Переводится', ['class' => 'btn btn-success w-100 d-block'])
                        : Html::tag('span', 'Не переводится', ['class' => 'btn btn-danger w-100 d-block']);
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'is_translatable',
                    'data' => [
                        1 => 'Переводится',
                        0 => 'Не переводится',
                    ],
                    'options' => [
                        'placeholder' => 'Показать всё',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]),
                'contentOptions' => ['class' => 'align-middle'],
            ],
            //'created_at',
            //'updated_at',
            [
                'class' => 'yii\\grid\\ActionColumn',
                'header' => 'Действия',
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{allButtons}',
                'buttons' => [
                    'allButtons' => function ($url, $model, $key) {
                        $buttons = Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], ['class' => 'btn btn-info']);
                        $buttons .= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mx-1']);

                        if (Yii::$app->user->can('delete settings')) {
                            $buttons .= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                'data-method' => 'post'
                            ]);
                        }

                        return Html::tag('div', $buttons, ['class' => 'd-flex align-items-center justify-content-center gap-1']);
                    },
                ],
            ],
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
