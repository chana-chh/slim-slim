<?php
namespace App\Middlewares;

/**
 * Ubacuje CSRF token polje u view
 * $csrf sadrzi kompletan html za csrf validaciju forme
 */
class CsrfMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {

		$csrf = '
		<input type="hidden" name="' . $this->c->csrf->getTokenNameKey() . '" value="' . $this->c->csrf->getTokenName() . '">
		<input type="hidden" name="' . $this->c->csrf->getTokenValueKey() . '" value="' . $this->c->csrf->getTokenValue() . '">
		';
		$this->c->view->addAttribute('csrf', $csrf);
		return $next($request, $response);
	}
}