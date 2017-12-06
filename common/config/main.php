<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'zh-CN',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'class' => \common\components\base\Formatter::className(),
            'datetimeFormat' => 'php:Y-m-d H:i:s',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
