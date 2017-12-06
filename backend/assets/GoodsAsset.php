<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class GoodsAsset extends AssetBundle
{
    public $sourcePath = '@bower/vue/dist';
    public $js = [
        'vue.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
