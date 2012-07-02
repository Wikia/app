<?php

class SpecialPageTriageList extends SpecialPage {

	public function __construct() {
		// Register special page
		parent::__construct( 'PageTriageList' );
	}
	
	public function execute( $sub ) {
		global $wgOut;

		// Begin output
		$this->setHeaders();
		
		
	}

}
