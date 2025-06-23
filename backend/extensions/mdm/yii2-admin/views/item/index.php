<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\RouteRule;
use mdm\admin\components\Configs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('rbac-admin', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <?= Html::a(Yii::t('rbac-admin', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'mt-2 text-center table table-striped table-bordered table-hover'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn',
                    'contentOptions' => ['class' => 'align-middle']
                ],
                [
                    'attribute' => 'name',
                    'label' => Yii::t('rbac-admin', 'Name'),
                    'contentOptions' => ['class' => 'align-middle'],
                ],
                [
                    'attribute' => 'ruleName',
                    'label' => Yii::t('rbac-admin', 'Rule Name'),
                    'filter' => $rules,
                    'contentOptions' => ['class' => 'align-middle'],
                ],
                [
                    'attribute' => 'description',
                    'label' => Yii::t('rbac-admin', 'Description'),
                    'contentOptions' => ['class' => 'align-middle'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class' => 'align-middle'],
                    'template' => '{view} {update} {delete}', // Customize the buttons here
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a(
                                '<i class="fas fa-eye"></i>',
                                $url,
                                [
                                    'class' => 'btn btn-info btn-sm',
                                    'title' => Yii::t('rbac-admin', 'View'),
                                    'aria-label' => Yii::t('rbac-admin', 'View'),
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                        'update' => function ($url, $model) {
                            return Html::a(
                                '<i class="fas fa-edit"></i>',
                                $url,
                                [
                                    'class' => 'btn btn-warning btn-sm',
                                    'title' => Yii::t('rbac-admin', 'Update'),
                                    'aria-label' => Yii::t('rbac-admin', 'Update'),
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            return Html::a(
                                '<i class="fas fa-trash"></i>',
                                $url,
                                [
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => Yii::t('rbac-admin', 'Delete'),
                                    'aria-label' => Yii::t('rbac-admin', 'Delete'),
                                    'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                    ],
                ],
            ],
        ]) ?>
    </div>
</div>
