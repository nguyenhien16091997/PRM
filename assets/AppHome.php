<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppHome extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
        //page level plugins
        'vendor/simple-line-icons/simple-line-icons.min.css',
        'vendor/bootstrap/css/bootstrap.min.css',
        'vendor/swiper/css/swiper.min.css',

        //page level scripts
        'css/site.css',
        'css/animate.css',
        'css/layout.min.css',

    ];
    public $js = [

        //core plugins
        'vendor/jquery.min.js',
        'vendor/jquery-migrate.min.js',
        'vendor/bootstrap/js/bootstrap.min.js',

        //level plugins
        'vendor/jquery.easing.js',
        'vendor/jquery.back-to-top.js',
        'vendor/jquery.smooth-scroll.js',
        'vendor/jquery.wow.min.js',
        'vendor/swiper/js/swiper.jquery.min.js',
        'vendor/masonry/jquery.masonry.pkgd.min.js',
        'vendor/masonry/imagesloaded.pkgd.min.js',

        //page level scripts
        'js/layout.min.js',
        'js/components/wow.min.js',
        'js/components/swiper.min.js',
        'js/components/masonry.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
