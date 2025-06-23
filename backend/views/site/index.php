<?php

/** @var yii\web\View $this */
/** @var int $transactionCount */
/** @var int $orderCount */

use yii\helpers\Url;

$this->title = 'Админ панель';
?>

<div class="container-fluid">
    <!-- Блок приветствия -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h2 class="mb-3"><i class="fas fa-tachometer-alt"></i> Добро пожаловать в Админ Панель</h2>
                    <p class="text-muted">
                        Здесь вы можете управлять сайтом, а также настраивать систему.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
