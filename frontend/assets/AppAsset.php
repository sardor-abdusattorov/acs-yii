<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/all.min.css',
        'css/styles.css',
        'vendor/fancybox/jquery.fancybox.min.css',
        'vendor/swiper/swiper-bundle.min.css',
    ];
    public $js = [
        'js/main.js',
        'vendor/fancybox/jquery.fancybox.min.js',
        'vendor/swiper/swiper-bundle.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}
