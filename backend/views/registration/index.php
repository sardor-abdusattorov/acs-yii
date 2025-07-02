<?php

use common\models\Registration;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\RegistrationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Регистрации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h3 class="d-inline"><?= Html::encode($this->title) ?></h3>
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
            'first_name',
            'last_name',
            'email:email',
            'phone',
            //'address',
            //'city',
            //'state',
            //'postal_code',
            //'sources',
            //'attendance_days',
            //'created_at',
            //'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{view}',
                'contentOptions' => ['class' => 'text-center'],
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a(
                            '<i class="fas fa-eye"></i>',
                            $url,
                            ['class' => 'btn btn-sm btn-info', 'title' => Yii::t('app', 'View')]
                        );
                    },
                ],
            ],
            ],
            'layout' => "{items}\n<div class=\"d-flex justify-content-start\">{pager}</div>",
            'pager' => [
            'class' => 'yii\bootstrap5\LinkPager',
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
            'linkOptions' => ['class' => 'page-link'],
            ],
            ]); ?>
        
            </div>
</div>
