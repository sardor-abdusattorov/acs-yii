<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    $usernameField,
];

if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}

$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'header' => 'Действия',
    'template' => '{view}', // Только кнопка "Просмотр"
    'buttons' => [
        'view' => function ($url, $model) {
            return Html::a(
                '<i class="fas fa-eye"></i>',
                $url,
                [
                    'class' => 'btn btn-info',
                    'title' => Yii::t('rbac-admin', 'View'),
                    'aria-label' => Yii::t('rbac-admin', 'View'),
                    'data-pjax' => '0',
                ]
            );
        },
    ],
];
?>

<div class="card">
    <div class="card-header">
        <div class="assignment-index">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="card-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'mt-2 text-center table table-striped table-bordered table-hover'],
            'columns' => $columns,
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
