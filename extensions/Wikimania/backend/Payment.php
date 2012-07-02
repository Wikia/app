<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Payment {
	/**
	 * Return the form for this payment provider, in HTML
	 * @return String
	 */
	abstract function getForm();
}

/**
 * Bogus class designed to throw an exception when it's used
 */
class PaymentBogus extends Payment {
	public function __construct() {
		throw new MWException( "Bogus payment handler defined" );
	}

	/** no-op */
	public function getForm() {}
}
