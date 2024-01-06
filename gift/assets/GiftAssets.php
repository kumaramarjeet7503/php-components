<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\modules\gift\assets;

use yii\web\AssetBundle;

class GiftAssets extends AssetBundle
{
    public $sourcePath =  __DIR__;
    public $css = [
        'css/gift.css',
    ];
    public $js = [
        'js/gift.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset'

    ];
}
