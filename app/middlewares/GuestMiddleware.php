<?php
namespace App\Middlewares;

/**
 * Pusta samo korisnike koji nisu prijavljeni
 */
class GuestMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {
		if($this->c->auth->prijavljen()) {
			return $response->withRedirect($this->c->router->pathFor('korisnik.pocetna'));
		}
		return $next($request, $response);
	}
}