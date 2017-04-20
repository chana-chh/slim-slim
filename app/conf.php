<?php
/*
    Konfiguracija aplikacije (settings)
 */
$config = [
    'settings' => [
        // Slim Settings
        'displayErrorDetails' => true,

        // Medoo
        'medoo' => [
            'database_type' => 'mysql',
            'database_name' => 'slim',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'option' => [
                \PDO::ATTR_PERSISTENT => true,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            ],
        ],
    ],
];