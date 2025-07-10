<?php

/** @var string $name */

use yii\helpers\Url;

$this->title = "404 ошибка";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="error-page">
    <h2 class="headline text-warning"> 404</h2>

    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Ой! Страница не найдена.</h3>

        <p>
            Мы не смогли найти страницу, которую вы искали.
            Тем временем вы можете <a href="<?=Url::home()?>">вернуться на главную</a> или попробовать использовать форму поиска.
        </p>
    </div>
</div>
