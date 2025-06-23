<?php

use common\components\StaticFunctions;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $user common\models\User */

?>

<aside class="main-sidebar sidebar-dark-primary">

    <a href="<?= Url::home() ?>" class="brand-link">
        <img src="<?= \Yii::getAlias('@web') ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-dark">ACDF</span>
    </a>

    <div class="sidebar">
        <?php if (!empty($user)): ?>
            <?php $image = StaticFunctions::getImage($user->avatar, 'user', $user->id) ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?= $image ?>" class="img-circle elevation-2" alt="User Image" style="height: 100%">
                </div>
                <div class="info">
                    <div class="d-block text-white">
                        <?= Html::encode($user->full_name) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item has-treeview <?= StaticFunctions::isGroupActive(['rbac', 'source-message', 'settings']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= StaticFunctions::isGroupActive(['rbac', 'source-message', 'settings']) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Настройки сайта
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="<?= Url::to(['/source-message']) ?>" class="nav-link <?= StaticFunctions::isActive('source-message') ?>">
                                <i class="fas fa-language nav-icon"></i>
                                <p>Переводы</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/rbac']) ?>" class="nav-link <?= StaticFunctions::isActive('rbac') ?>">
                                <i class="fas fa-user-shield nav-icon"></i>
                                <p>RBAC</p>
                            </a>
                        </li>
                    </ul>

                </li>

            </ul>
        </nav>
    </div>
</aside>

