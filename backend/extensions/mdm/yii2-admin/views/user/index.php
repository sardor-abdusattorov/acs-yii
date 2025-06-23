    <?php

    use common\components\StaticFunctions;
    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $searchModel mdm\admin\models\searchs\User */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = Yii::t('rbac-admin', 'Users');
    $this->params['breadcrumbs'][] = $this->title;
    ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            <div class="card-tools">
                <?= Html::a('Добавить нового пользователя', ['signup'], ['class' => 'btn btn-success']); ?>
            </div>
        </div>

        <div class="card-body">
            <div class="user-index">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'mt-2 text-center table table-striped table-bordered table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'contentOptions' => ['class' => 'align-middle'],
                        ],
                        [
                            'attribute' => 'username',
                            'contentOptions' => ['class' => 'align-middle'],
                        ],
                        [
                            'attribute'=>'avatar',

                            'value'=>function($data){
                                $image = StaticFunctions::getImage($data->avatar,'user',$data->id);
                                return "<img src='$image' style='max-width: 100px' alt='<?=$data->avatar?>'>";
                            },
                            'format'=>"html"
                        ],
                        [
                            'attribute' => 'full_name',
                            'contentOptions' => ['class' => 'align-middle'],
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return $model->status == 0
                                    ? '<span class="badge bg-secondary">Неактивный</span>'
                                    : '<span class="badge bg-success">Активный</span>';
                            },
                            'format' => 'html',
                            'contentOptions' => ['class' => 'align-middle'],
                            'filter' => [
                                0 => 'Неактивный',
                                10 => 'Активный'
                            ]
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Действия',
                            'template' => '{update} {view} {activate} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    return Html::a(
                                        '<i class="fas fa-edit"></i>',
                                        $url,
                                        [
                                            'class' => 'btn btn-primary',
                                            'title' => Yii::t('rbac-admin', 'update'),
                                            'aria-label' => Yii::t('rbac-admin', 'update'),
                                            'data-pjax' => '0',
                                        ]
                                    );
                                },
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
                                'activate' => function ($url, $model) {
                                    if ($model->status == 10) {
                                        return '';
                                    }
                                    return Html::a(
                                        '<i class="fas fa-check"></i>',
                                        $url,
                                        [
                                            'class' => 'btn btn-secondary',
                                            'title' => Yii::t('rbac-admin', 'Activate'),
                                            'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                        ]
                                    );
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a(
                                        '<i class="fas fa-trash"></i>',
                                        $url,
                                        [
                                            'class' => 'btn btn-danger',
                                            'title' => Yii::t('rbac-admin', 'Delete'),
                                            'aria-label' => Yii::t('rbac-admin', 'Delete'),
                                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to delete this user?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                        ]
                                    );
                                },
                            ],
                            'contentOptions' => ['class' => 'align-middle'],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
