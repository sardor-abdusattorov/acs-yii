<?php

use common\components\StaticFunctions;
use common\models\User;
use yii\helpers\Url;
/* @var $departmentName string */
/* @var $positionName string */
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item d-none d-sm-inline-block ml-4">
            <a href="<?=Url::to(['/gii'])?>" class="btn btn-success px-4">GII</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block ml-4">
            <a href="<?= Yii::$app->params['frontend'] ?>" class="btn btn-primary px-4" target="_blank">Сайт</a>
        </li>


        <?php if (User::getMyRole() === 'admin'):?>

            <li class="nav-item d-none d-sm-inline-block ml-4">
                <a href="<?= Url::to(['/gii'])?>" class="btn btn-success">GII</a>
            </li>

        <?php endif; ?>

    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="#" class="nav-link" id="darkModeToggle">
                <i class="fas fa-moon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <?php if(!empty($user)): ?>
            <?php $image = StaticFunctions::getImage($user->avatar, 'user', $user->id) ?>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?=$image?>" class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline"><?=$user->full_name?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Добро пожаловать !</h6>
                    </div>


                    <div class="dropdown-divider"></div>

                    <a href="<?=Url::to(['/logout'])?>" class="dropdown-item notify-item">Выйти</a>
                </ul>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="<?=$image?>" class="rounded-circle shadow" alt="User Image">
                        <p>
                            <?=$user->full_name?>
                        </p>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

    </ul>
</nav>
