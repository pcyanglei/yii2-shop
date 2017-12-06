<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'crud'  => [
                'class'     => 'yh\gii\generators\crud\Generator',
                'templates' => [
                    'zh' => '@common/yh-gii/generators/crud/default',
                ]
            ],
            'model' => [
                'class'     => 'yii\gii\generators\model\Generator',
                'templates' => [
                    'zh' => '@common/yh-gii/generators/model/default',
                ]
            ],
        ]
    ];
}

return $config;
