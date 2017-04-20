<?php
/*
	Dependency Injection Container
 */
$container = $app->getContainer();

// Medoo
$container['db'] = function ($container) {
    $conf = $container['settings']['medoo'];
    $db = new \App\Models\Medoo($conf);
    return $db;
};

// CSRF
$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};

// Auth klasa
$container['auth'] = function ($container) {
    return new \App\Classes\Auth($container->db);
};

// View
$container['view'] = new \Slim\Views\PhpRenderer(
		DIR . 'app/views',
		[ // Globalne promenjive za view
			'auth' => [
				'prijavljen' => $container['auth']->prijavljen(),
				'korisnik' => $container['auth']->korisnik(),
			],
		]
);