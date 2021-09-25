<?php

require_once __DIR__ .'/../framework/yii.php';
$config = __DIR__ .'/../protected/config/main.php';
Yii::createWebApplication($config)->run();