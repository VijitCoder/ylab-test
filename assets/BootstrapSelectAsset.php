<?php
namespace app\assets;

use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * bootstrap-select
 */
class BootstrapSelectAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-select/dist';
    public $css = [
        'css/bootstrap-select.min.css'
    ];
    public $js = [
        'js/bootstrap-select.min.js'
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,       // Bootstrap css
        BootstrapPluginAsset::class, // Bootstrap js
    ];
}
