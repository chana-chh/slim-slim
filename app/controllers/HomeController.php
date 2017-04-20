<?php
namespace App\Controllers;

class HomeController extends Controller {

	/**
	 * Pocetna stranica (home)
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getPocetna($request, $response) {
		$prom = [
				'naslov' => 'Pocetna stranica',
	    		'stranica' => 'pocetna',
	    		'router' => $this->router,
	    	];
	    return $this->render($response, 'template.phtml', $prom);
	}

	/**
	 * Medoo dokumentacija
	 * @param  [type] $request  [description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	public function getMedoo($request, $response) {
		$prom = [
				'naslov' => 'Medoo',
	    		'stranica' => 'medoo',
	    		'router' => $this->router,
	    		'db' => $this->db,
	    	];
	    return $this->render($response, 'template.phtml', $prom);
	}
}