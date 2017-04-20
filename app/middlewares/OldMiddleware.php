<?php
namespace App\Middlewares;

/**
 * Ubacuje $staro promenjivu u view
 * $staro sadrzi podatke o starim vrednostima polja na formi
 */
class OldMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {
		if(isset($_SESSION['staro'])) {
			$this->c->view->addAttribute('staro', $_SESSION['staro']);	
		}
		$_SESSION['staro'] = $request->getParams();
		return $next($request, $response);
	}
}