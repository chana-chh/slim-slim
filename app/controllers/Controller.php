<?php
namespace App\Controllers;

/**
 * Osnovni controller
 */
class Controller {
	
	// DIC
	protected $c;

	function __construct($c) {
		$this->c = $c;
	}

	/**
	 * Priprema pogleda
	 * @param  Response $response
	 * @param  string $template 	naziv templejta koji se prikazuje
	 * @param  array $vars 			promenjive koje se prosledjuju templejtu
	 */
	protected function render($response, $template, $vars) {
		$this->c->view->render($response, $template, $vars);
	}

	/**
	 * Preuzima objekte iz DIC-a ako postoje
	 * @param  string $ime Naziv objekta
	 * @return Object      Objekat iz DIC-a
	 */
	public function __get($ime) {
		return $this->c->get($ime);
	}
}