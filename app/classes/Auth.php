<?php
namespace App\Classes;

/**
 * Autorizacija korisnika
 */
class Auth {

	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	/**
	 * Prijava korisnika
	 * @param  string $email   Email korisnika
	 * @param  string $lozinka Lozinka Korisnika
	 * @return boolean         Da li je uspelo prijavljivanje korisnika
	 */
	public function prijava($email, $lozinka) {
		$korisnik = $this->db->get('korisnici', '*', ['email' => $email]);
		if(!$korisnik) {
			return false;
		}
		// Ako je potrebno dodati proveru da li je korisnik aktivan
		// if($korisnik['aktivan'] === '0') {
		// 	return false;
		// }
		if($this->proveriLozinku($lozinka, $korisnik['lozinka'])) {
			$_SESSION['korisnik'] = $korisnik['id'];
			return true;
		}
		return false;
	}

	/**
	 * Provera da li je korisnik prijavljen
	 * @return boolean  Da li je korisnik prijavljen
	 */
	public function prijavljen() {
		return isset($_SESSION['korisnik']);
	}

	/**
	 * Vraca korisnika koji je prijavljen
	 * @return mixed array|null Vraca prijavljenog korisnika ili null ako nije prijavljen
	 */
	public function korisnik() {
		if(isset($_SESSION['korisnik'])) {
			return $this->db->get('korisnici', '*', ['id' => $_SESSION['korisnik']]);	
		}
		return null;
	}

	/**
	 * Odjava korisnika
	 */
	public function odjava() {
		unset($_SESSION['korisnik']);
	}

	/**
	 * Provera lozinke
	 * @param  string $tekst Lozinka (iz forme)
	 * @param  string $hash  Hash lozinke (iz baze)
	 * @return boolean       Da li lozinka odgovara hash-u
	 */
	public function proveriLozinku($tekst, $hash) {
		return password_verify($tekst, $hash);
	}
}