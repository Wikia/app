<?php
if (!defined('MEDIAWIKI')) die();

class SpecialRandomrootpage extends RandomPage {

	public function __construct() {
		parent::__construct( 'Randomrootpage' );
		$this->extra[] = "page_title NOT LIKE '%/%'";
	}

	// Don't select redirects
	public function isRedirect(){
		return false;
	}
}
