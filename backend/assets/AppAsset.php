<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
          "dist/fonts/stylesheet.css",
          "plugins/fontawesome-free/css/all.min.css",
          "plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
          "plugins/toastr/toastr.min.css",
          "plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css",
          'dist/css/ionicons.min.css',
          "dist/css/adminlte.min.css",
          "dist/css/custom.css",
    ];
    public $js = [
        "plugins/bootstrap/js/bootstrap.bundle.min.js",
        "plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
        "dist/js/adminlte.min.js",
        "plugins/toastr/toastr.min.js",
        "plugins/bootstrap-switch/js/bootstrap-switch.min.js",
        'dist/js/custom.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
