<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Registration $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Регистрации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h2 class="mb-3"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="card-body">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'last_name',
            'email:email',
            'phone',
            'address',
            'city',
            'state',
            'postal_code',
            'sources',
            'attendance_days',
            'created_at',
            'updated_at',
        ],
        ]) ?>
    </div>
</div>
