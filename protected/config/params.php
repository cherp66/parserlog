<?php

return [

    // Настройки парсера лога apache
    'apache_log' => [
        'logfiles' => [
            'default' => 'C:\server\logs\access.log',
            'openserver'  => 'C:\OpenServer\userdata\logs\Apache_2.4-PHP_7.2-7.4+Nginx_1.21_queriesa.log',
        ],
        
        'format' => [
            'default' => 'common',
            'openserver'  => '%v: %a %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"'
         ],
    ],

    'title' => 'Тестовое задание',
];
