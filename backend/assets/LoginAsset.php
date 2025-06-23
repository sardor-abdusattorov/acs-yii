<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        "plugins/toastr/toastr.min.css"
    ];
    public $js = [
         "dist/js/adminlte.min.js",
        "plugins/toastr/toastr.min.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
