<?php

use common\components\StaticFunctions;
use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$controllerId = $this->context->uniqueId . '/';
?>

<div class="card">
    <div class="card-header">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="card-body">
        <div class="user-view">
            <p>
                <?php
                if ($model->status == 0 && Helper::checkRoute($controllerId . 'activate')) {
                    echo Html::a(Yii::t('rbac-admin', 'Activate'), ['activate', 'id' => $model->id], [
                        'class' => 'btn btn-primary',
                        'data' => [
                            'confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'method' => 'post',
                        ],
                    ]);
                }
                ?>
                <?php
                if (Helper::checkRoute($controllerId . 'delete')) {
                    echo Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                }

                if (Helper::checkRoute($controllerId . 'update')) {
                    echo Html::a(Yii::t('rbac-admin', 'Update'), ['update', 'id' => $model->id], [
                        'class' => 'btn btn-primary ml-3',
                    ]);
                }
                ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'username',
                    'full_name',
                    'email:email',
                    [
                        'attribute' => 'created_at',
                        'format' => ['datetime', 'php:Y-m-d H:i:s'],
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($data) {
                            return $data->status == 10 ? 'Активный' : 'Неактивный';
                        },
                    ],
                    [
                        'attribute' => 'avatar',
                        'value' => function($data) {
                            $image = StaticFunctions::getImage($data->avatar, 'user', $data->id);
                            return "<img src='$image' style='max-width: 150px' alt='{$data->avatar}'>";
                        },
                        'format' => "html"
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
