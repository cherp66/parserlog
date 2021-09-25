<?php

return [
    'basePath' => __DIR__ . '/../',
    'name' => 'application',
    'aliases' => [
        'views' => 'application.views',
        'widgets' => 'application.widgets'
    ],
    'preload' => ['log'],      
    'import' => [
        'application.controllers.*',
        'application.models.*',
        'application.components.*',
    ],

    'defaultController' => 'apachelog',

    'components' => [ 
        'db' => require_once __DIR__ .'/db.php', 
        
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => [
                'login' => 'auth/login',
                'logout' => 'auth/logout',
                'content' => 'apachelog/content',
            ],
        ],
        
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
            ],
        ],
    ],

    'params' => require_once __DIR__ .'/params.php',
];