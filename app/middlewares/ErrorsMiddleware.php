<?php
namespace App\Middlewares;

/**
 * Ubacuje $greske promenjivu u view
 * $greske sadrzi podatke o greskama pri popunjavanju forme
 */
class ErrorsMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {
		$greske = null;
		if(isset($_SESSION['greske'])) {
			$greske = $_SESSION['greske'];
			unset($_SESSION['greske']);
		}
		$this->c->view->addAttribute('greske', $greske);
		return $next($request, $response);
	}
}