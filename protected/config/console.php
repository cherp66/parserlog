<?php

return [

    'basePath' => __DIR__ . '/../',
    'name' => 'сonsole',

    'import' => [
        'application.helpers.*',
        'application.commands.*',
    ],
    
    'components' => [   
        'db' => require_once __DIR__ .'/db.php',  
    ],
    
    'params' => require_once __DIR__ .'/params.php',
];