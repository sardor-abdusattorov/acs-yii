<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\BizRule */

$this->title = Yii::t('rbac-admin', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <?= Html::a(Yii::t('rbac-admin', 'Create Rule'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="card-body">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'label' => Yii::t('rbac-admin', 'Name'),
                ],
                ['class' => 'yii\grid\ActionColumn',],
            ],
        ]);
        ?>
    </div>
</div>