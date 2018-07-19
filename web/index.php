<?php
require __DIR__ . '/../customizer/bootstrap.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
