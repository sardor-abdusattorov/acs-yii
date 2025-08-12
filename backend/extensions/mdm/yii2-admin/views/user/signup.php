<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \mdm\admin\models\form\Signup */
/* @var array $positionsData */

$this->title = Yii::t('rbac-admin', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="card-body">
        <?= Html::errorSummary($model) ?>
        <?= $this->render('_form', [
            'model' => $model
        ]) ?>
    </div>
</div>
