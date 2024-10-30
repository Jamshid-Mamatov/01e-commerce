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
        'css/plugins.min.css',
        'css/style.css',
        'css/swiper-bundle.min.css',
        'css/animate.min.css'

    ];
    public $js = [
//        'js/vendor.min.js',
        'js/plugins.min.js',
        'js/main.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
