<?php
namespace App\Controllers;

/**
 * Autorizacija korisnika
 */
class AuthController extends Controller {

	/**
	 * Registracija korisnika GET
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getRegistracija($request, $response) {
		$prom = [
				'naslov' => 'Registracija',
	    		'stranica' => 'auth/registracija',
	    		'router' => $this->router,
	    	];
	    return $this->render($response, 'template.phtml', $prom);
	}

	/**
	 * Registracija korisnika POST
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function postRegistracija($request, $response) {
		$params = $request->getParams();
		$email = filter_var($params['email'], FILTER_SANITIZE_EMAIL);
		$lozinka = filter_var($params['lozinka'], FILTER_SANITIZE_STRING);
		$lozinka_p = filter_var($params['lozinka_p'], FILTER_SANITIZE_STRING);
		// Validacija
		$greske = $this->validacijaRegistracije($email, $lozinka, $lozinka_p);
		if(!empty($greske)) {
			$_SESSION['greske'] = $greske;
			return $response->withRedirect($this->router->pathFor('registracija'));
		}
		// Upisivanje novog korisnika u bazu
		$korisnik['email'] = $params['email'];
		$korisnik['lozinka'] = password_hash($lozinka, PASSWORD_DEFAULT);
		$id = $this->db->insert('korisnici', $korisnik);
		// Ako se korisnik automatski loguje prilikom prijave
		// $this->auth->prijava($email, $lozinka);
		return $response->withRedirect($this->router->pathFor('pocetna'));
	}

	/**
	 * Projava korisnika GET
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getPrijava($request, $response) {
		$prom = [
				'naslov' => 'Prijava',
	    		'stranica' => 'auth/prijava',
	    		'router' => $this->router,
	    	];
	    return $this->render($response, 'template.phtml', $prom);
	}

	/**
	 * Prijava korisnika POST
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function postPrijava($request, $response) {
		$params = $request->getParams();
		$email = filter_var($params['email'], FILTER_SANITIZE_EMAIL);
		$lozinka = filter_var($params['lozinka'], FILTER_SANITIZE_STRING);
		// Validacija
		$greske = $this->validacijaPrijava($email, $lozinka);
		if(!empty($greske)) {
			$_SESSION['greske'] = $greske;
			return $response->withRedirect($this->router->pathFor('prijava'));
		}
		// Prijavljivanje korisnika (login)
		$auth = $this->auth->prijava($email, $lozinka);
		if(!$auth) {
			return $response->withRedirect($this->router->pathFor('prijava'));
		}
		return $response->withRedirect($this->router->pathFor('korisnik.pocetna'));
	}

	/**
	 * Odjavljivanje korisnika GET
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getOdjava($request, $response) {
		// Odjavljivanje korisnika (logout)
		$this->auth->odjava();
		return $response->withRedirect($this->router->pathFor('pocetna'));
	}

	/**
	 * Validacija registracije
	 * @param  [type] $email     [description]
	 * @param  [type] $lozinka   [description]
	 * @param  [type] $lozinka_p [description]
	 * @return [type]            [description]
	 */
	private function validacijaRegistracije($email, $lozinka, $lozinka_p) {
		$greske = [];
		if(empty($email)) {
			$greske['email'] = 'Email ne sme biti prazan';
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$greske['email'] = 'Email adresa nije validna';
		}
		if($this->db->has('korisnici', ['email' => $email])) {
			$greske['email'] = 'Email adresa je zauzeta';
		}
		if(empty($lozinka)) {
			$greske['lozinka'] = 'Lozinka ne sme biti prazna';
		}
		if(empty($lozinka_p)) {
			$greske['lozinka_p'] = 'Potvrda lozinka ne sme biti prazna';
		}
		if($lozinka !== $lozinka_p) {
			$greske['lozinka_p'] = 'Lozinka i potvrda lozinke moraju biti iste';
		}
		return $greske;
	}

	/**
	 * Validacija prijave
	 * @param  [type] $email   [description]
	 * @param  [type] $lozinka [description]
	 * @return [type]          [description]
	 */
	private function validacijaPrijava($email, $lozinka) {
		$greske = [];
		if(empty($email)) {
			$greske['email'] = 'Email ne sme biti prazan';
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$greske['email'] = 'Email adresa nije validna';
		}
		if(empty($lozinka)) {
			$greske['lozinka'] = 'Lozinka ne sme biti prazna';
		}
		return $greske;
	}
}
