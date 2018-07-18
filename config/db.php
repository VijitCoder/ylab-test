<?php
return [
    'class' => yii\db\Connection::class,
    'dsn' => env('DB_DSN'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'tablePrefix' => '',
    'charset' => 'utf8mb4',
    'enableSchemaCache' => YII_ENV_PROD,

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
