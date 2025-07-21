<?php

use common\components\StaticFunctions;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $user common\models\User */

?>

<aside class="main-sidebar sidebar-dark-primary">
    <a href="<?= Url::home() ?>" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-dark">ACDF</span>
    </a>
    <div class="sidebar">
        <?php if (!empty($user)): ?>
            <?php $image = StaticFunctions::getImage($user->avatar, 'user', $user->id) ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?= $image ?>" class="img-circle elevation-2" alt="User Image" style="height: 100%;">
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
                <!-- Контент -->
                <li class="nav-item has-treeview <?= StaticFunctions::isGroupActive(['books', 'articles', 'archive-news', 'event-program', 'tags', 'locations']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= StaticFunctions::isGroupActive(['books', 'articles', 'archive-news', 'event-program', 'tags', 'locations']) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            Контент
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= Url::to(['/books']) ?>" class="nav-link <?= StaticFunctions::isActive('books') ?>"><i class="fas fa-book nav-icon"></i><p>Книги</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/articles']) ?>" class="nav-link <?= StaticFunctions::isActive('articles') ?>"><i class="fas fa-newspaper nav-icon"></i><p>Статьи</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/archive-news']) ?>" class="nav-link <?= StaticFunctions::isActive('archive-news') ?>"><i class="fas fa-archive nav-icon"></i><p>Архив новостей</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/event-program']) ?>" class="nav-link <?= StaticFunctions::isActive('event-program') ?>"><i class="fas fa-calendar-alt nav-icon"></i><p>Программы</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/tags']) ?>" class="nav-link <?= StaticFunctions::isActive('tags') ?>"><i class="fas fa-tags nav-icon"></i><p>Тэги</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/locations']) ?>" class="nav-link <?= StaticFunctions::isActive('locations') ?>"><i class="fas fa-map-marker-alt nav-icon"></i><p>Локации</p></a></li>
                    </ul>
                </li>

                <!-- Вне групп: Меню и соц. сети -->
                <li class="nav-item"><a href="<?= Url::to(['/menu']) ?>" class="nav-link <?= StaticFunctions::isActive('menu') ?>"><i class="fas fa-bars nav-icon"></i><p>Меню</p></a></li>
                <li class="nav-item"><a href="<?= Url::to(['/social-links']) ?>" class="nav-link <?= StaticFunctions::isActive('social-links') ?>"><i class="fas fa-share-alt nav-icon"></i><p>Социальные сети</p></a></li>

                <!-- Страницы -->
                <li class="nav-item has-treeview <?= StaticFunctions::isGroupActive(['pages', 'page-sections', 'sections']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= StaticFunctions::isGroupActive(['pages', 'page-sections', 'sections']) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Страницы сайта
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= Url::to(['/sections']) ?>" class="nav-link <?= StaticFunctions::isActive('sections') ?>"><i class="fas fa-layer-group nav-icon"></i><p>Секции</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/pages']) ?>" class="nav-link <?= StaticFunctions::isActive('pages') ?>"><i class="fas fa-file-alt nav-icon"></i><p>Страницы</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/page-sections']) ?>" class="nav-link <?= StaticFunctions::isActive('page-sections') ?>"><i class="fas fa-th-large nav-icon"></i><p>Секции страниц</p></a></li>
                    </ul>
                </li>

                <!-- Отклики -->
                <li class="nav-item has-treeview <?= StaticFunctions::isGroupActive(['subscribers', 'registration']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= StaticFunctions::isGroupActive(['subscribers', 'registration']) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Отклики
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= Url::to(['/subscribers']) ?>" class="nav-link <?= StaticFunctions::isActive('subscribers') ?>"><i class="fas fa-envelope nav-icon"></i><p>Подписчики</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/registration']) ?>" class="nav-link <?= StaticFunctions::isActive('registration') ?>"><i class="fas fa-user-plus nav-icon"></i><p>Регистрации на саммит</p></a></li>
                    </ul>
                </li>

                <!-- Системные -->
                <li class="nav-item has-treeview <?= StaticFunctions::isGroupActive(['rbac', 'source-message', 'settings']) ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= StaticFunctions::isGroupActive(['rbac', 'source-message', 'settings']) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Настройки сайта
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= Url::to(['/settings']) ?>" class="nav-link <?= StaticFunctions::isActive('settings') ?>"><i class="fas fa-cog nav-icon"></i><p>Настройки значений</p></a></li>
                        <li class="nav-item"><a href="<?= Url::to(['/source-message']) ?>" class="nav-link <?= StaticFunctions::isActive('source-message') ?>"><i class="fas fa-language nav-icon"></i><p>Переводы</p></a></li>
                        <?php if (User::isSuperadmin()): ?>
                            <li class="nav-item"><a href="<?= Url::to(['/rbac']) ?>" class="nav-link <?= StaticFunctions::isActive('rbac') ?>"><i class="fas fa-user-shield nav-icon"></i><p>RBAC</p></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>

