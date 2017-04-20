<?php
namespace App\Middlewares;

/**
 * Pusta samo prijavljene korisnike
 */
class AuthMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {
		if(!$this->c->auth->prijavljen()) {
			return $response->withRedirect($this->c->router->pathFor('prijava'));
		}
		return $next($request, $response);
	}
}