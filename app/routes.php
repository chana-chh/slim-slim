<?php
/*
	Vidljivo uvek
 */
$app->get('/', '\App\Controllers\HomeController:getPocetna')->setName('pocetna');
$app->get('/medoo', '\App\Controllers\HomeController:getMedoo')->setName('medoo');

/*
	Vidljivo samo kada nisi prijavljen
 */
$app->group('', function() {
	$this->get('/registracija', '\App\Controllers\AuthController:getRegistracija')->setName('registracija');
	$this->post('/registracija', '\App\Controllers\AuthController:postRegistracija');
	$this->get('/prijava', '\App\Controllers\AuthController:getPrijava')->setName('prijava');
	$this->post('/prijava', '\App\Controllers\AuthController:postPrijava');
})->add(new \App\Middlewares\GuestMiddleware($container));

/*
	Vidljivo samo kada si prijavljen
 */
$app->group('', function() {
	$this->get('/odjava', '\App\Controllers\AuthController:getOdjava')->setName('odjava');
	$this->get('/korisnik', '\App\Controllers\KorisnikController:getPocetna')->setName('korisnik.pocetna');
	$this->get('/korisnik/promena-lozinke', '\App\Controllers\KorisnikController:getPromenaLozinke')->setName('korisnik.promena-lozinke');
	$this->post('/korisnik/promena-lozinke', '\App\Controllers\KorisnikController:postPromenaLozinke');
})->add(new \App\Middlewares\AuthMiddleware($container));