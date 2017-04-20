<?php
namespace App\Middlewares;

/**
 * Osnovni middleware
 */
class Middleware {

	protected $c;
	
	function __construct($c) {
		$this->c = $c;
	}
}