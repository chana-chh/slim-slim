<?php
namespace App\Controllers;

class KorisnikController extends Controller {

	/**
	 * Korisnik pocetna strana
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getPocetna($request, $response) {
		$prom = [
				'naslov' => 'Administracija',
	    		'stranica' => 'korisnik/pocetna',
	    		'router' => $this->router,
	    	];
	    return $this->render($response, 'template.phtml', $prom);
	}

	/**
	 * Promena lozinke GET
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getPromenaLozinke($request, $response) {
		$prom = [
				'naslov' => 'Promena lozinke',
	    		'stranica' => 'korisnik/promena_lozinke',
	    		'router' => $this->router,
	    	];
	    return $this->render($response, 'template.phtml', $prom);
	}

	/**
	 * Promena lozinke POST
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function postPromenaLozinke($request, $response) {
		$params = $request->getParams();
		$nova_lozinka = filter_var($params['nova_lozinka'], FILTER_SANITIZE_STRING);
		$trenutna_lozinka = filter_var($params['trenutna_lozinka'], FILTER_SANITIZE_STRING);
		// Validacija
		$greske = $this->validacijaPromenaLozinke($nova_lozinka, $trenutna_lozinka);
		if(!empty($greske)) {
			$_SESSION['greske'] = $greske;
			return $response->withRedirect($this->router->pathFor('korisnik.promena-lozinke'));
		}
		// Upisivanje nove lozinke u bazu
		$this->db->update(
			'korisnici',
			['lozinka' => password_hash($nova_lozinka, PASSWORD_DEFAULT)],
			['id' => $_SESSION['korisnik']]
		);
		return $response->withRedirect($this->router->pathFor('korisnik.pocetna'));
	}

	/**
	 * Validacija promene lozinke
	 * @param  [type] $nova_lozinka     [description]
	 * @param  [type] $trenutna_lozinka [description]
	 * @return [type]                   [description]
	 */
	private function validacijaPromenaLozinke($nova_lozinka, $trenutna_lozinka) {
		$greske = [];
		if(empty($nova_lozinka)) {
			$greske['nova_lozinka'] = 'Nova lozinka ne sme biti prazna';
		}
		// Provera da li je trenutna lozinka ok
		$korisnik = $this->auth->korisnik();
		$provera = $this->auth->proveriLozinku($trenutna_lozinka, $korisnik['lozinka']);
		if(!$provera) {
			$greske['trenutna_lozinka'] = 'Niste uneli ispravnu trenutnu lozinku';
		}
		return $greske;
	}
}