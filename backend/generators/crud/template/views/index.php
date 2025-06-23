<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var yii\gii\generators\crud\Generator $generator */

$modelClass = StringHelper::basename($generator->modelClass);

echo "<?php\n";
?>

use <?= $generator->modelClass ?>;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/** @var yii\web\View $this */
<?= !empty($generator->searchModelClass) ? "/** @var " . ltrim($generator->searchModelClass, '\\') . " \$searchModel */\n" : '' ?>
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header">
        <h3 class="d-inline"><?= "<?= " ?>Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="card-body">
        <?= $generator->enablePjax ? "<?php Pjax::begin(); ?>\n" : '' ?>
        <?php if (!empty($generator->searchModelClass)): ?>
            <?= "<?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php endif; ?>

        <?php if ($generator->indexWidgetType === 'grid'): ?>
            <?= "<?= " ?>GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'mt-2 text-center table table-striped table-bordered align-middle'],
            <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn',
            'contentOptions' => ['class' => 'align-middle'],
            ],

            <?php
            $count = 0;
            if (($tableSchema = $generator->getTableSchema()) === false) {
                foreach ($generator->getColumnNames() as $name) {
                    if (++$count < 6) {
                        echo "            '" . $name . "',\n";
                    } else {
                        echo "            //'" . $name . "',\n";
                    }
                }
            } else {
                foreach ($tableSchema->columns as $column) {
                    $format = $generator->generateColumnFormat($column);
                    if (++$count < 6) {
                        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    } else {
                        echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                }
            }
            ?>
            [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
            'contentOptions' => ['class' => 'text-center'],
            'buttons' => [
            'view' => function ($url) {
            return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-info']);
            },
            'update' => function ($url) {
            return Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-primary']);
            },
            'delete' => function ($url) {
            return Html::a('<i class="fas fa-trash"></i>', $url, [
            'class' => 'btn btn-danger mx-1',
            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
            'data-method' => 'post'
            ]);
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
        <?php else: ?>
            <?= "<?= " ?>ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $generator->getNameAttribute() ?>), ['view', <?= $generator->generateUrlParams() ?>]);
            },
            ]) ?>
        <?php endif; ?>

        <?= $generator->enablePjax ? "<?php Pjax::end(); ?>\n" : '' ?>
    </div>
</div>
