<?php
// Startovanje sesije
session_start();
// Postavljanje osnovnog direktorijuma
define('DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);
// Ucitavanje autoloader-a
require DIR . 'vendor/autoload.php';
// Ucitavanje pomocnih funkcija (moze da se brise u produkciji)
require DIR . 'app/fje.php';
// Ucitavanje podaesavanja
require DIR . 'app/conf.php';
// Kreiranje aplikacije
$app = new \Slim\App($config);
// Ucitavanje DIC-a (Dependency Injection Container)
require DIR . 'app/dic.php';
// Postavljanje osnovnog URL-a
$host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
define('URL', $host . $container['request']->getUri()->getBasePath());
// Ucitavanje middleware-a
require DIR . 'app/mid.php';
// Ucitavanje putanji (ruta)
require DIR . 'app/routes.php';
// Startovanje aplikacije
$app->run();