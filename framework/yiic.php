<?php

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once __DIR__ .'/yii.php' ;

$app = Yii::createConsoleApplication($config);
$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
$app->run();