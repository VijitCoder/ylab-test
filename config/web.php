<?php
$config = [
    'id' => 'basic',
    'name' => 'YLab job test',
    'basePath' => dirname(__DIR__),
    'homeUrl' => env('HOME_URL'),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    
    'components' => require __DIR__ . '/components.php',
    
    'params' => require __DIR__ . '/params.php',
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = ['class' => \yii\debug\Module::class,];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class' => \yii\gii\Module::class,];
}

return $config;
