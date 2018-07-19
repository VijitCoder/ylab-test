<?php
// Custom bootstrap for Yii project

$rootPath = realpath(__DIR__ . '/../');

require $rootPath . '/vendor/autoload.php';

// Load application environment from .env file
$dotenv = new \Dotenv\Dotenv($rootPath);
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG', true));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV', 'dev'));

require $rootPath . '/vendor/yiisoft/yii2/Yii.php';
