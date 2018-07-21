<?php
return [
    'request' => [
        'cookieValidationKey' => 'uUXdchTUUWom5zo1Co0-p4YJ2mg54R-A',
    ],

    'cache' => [
        'class' => \yii\caching\FileCache::class,
    ],

    'errorHandler' => [
        'errorAction' => 'site/error',
    ],

    'mailer' => [
        'class'            => \yii\swiftmailer\Mailer::class,
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => true,
    ],

    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets'    => [
            [
                'class'  => \yii\log\FileTarget::class,
                'levels' => ['error', 'warning'],
            ],
        ],
    ],

    'assetManager' => [
        'class'           => \yii\web\AssetManager::class,
        'linkAssets'      => true,
        'appendTimestamp' => YII_ENV_DEV,
    ],

    'db' => require __DIR__ . '/db.php',

    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName'  => false,
        'rules'           => [
            '<controller>/<id:\d+>' => '<controller>/view',
            '<controller>/<action>' => '<controller>/<action>',
        ],
    ],
];
