<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Menu $model */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var array $languages */
/** @var array $parents */

$languages = Yii::$app->params['languages'];
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <!-- Переводы -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <?php foreach ($languages as $code => $name): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $code === Yii::$app->language ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#lang-<?= $code ?>" type="button">
                                <?= Html::encode($name) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content">
                    <?php foreach ($languages as $code => $name): ?>
                        <div class="tab-pane fade <?= $code === Yii::$app->language ? 'show active' : '' ?>" id="lang-<?= $code ?>" role="tabpanel">
                            <?= $form->field($model->translate($code), "[$code]title")->textInput([
                                'maxlength' => true,
                                'placeholder' => "Заголовок на {$name}"
                            ])->label("Заголовок ({$name})") ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'position')->dropDownList(Yii::$app->params['menu_positions'], [
            'prompt' => 'Выберите позицию в меню'
        ]) ?>

        <?= $form->field($model, 'parent_id')->dropDownList($parents, [
            'prompt' => 'Нет родительского (основной пункт)'
        ]) ?>

        <?= $form->field($model, 'order_by')->textInput([
            'placeholder' => 'Укажите порядок сортировки (например, 10, 20, 30...)'
        ]) ?>

        <?= $form->field($model, 'status')->dropDownList([
            1 => 'Активно',
            0 => 'Неактивно',
        ], ['prompt' => 'Выберите статус']) ?>
    </div>
</div>

<div class="form-group mt-3">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
