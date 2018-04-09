<?php

class SpecialPiggybackRedirect extends SpecialPage {

	public function __construct( string $name = 'Piggyback' ) {
		parent::__construct( $name );
	}

	function execute( $par ) {
		$this->setHeaders();

		$target = urlencode( $par ?: $this->getRequest()->getVal( 'target' ) );

		$this->getOutput()->redirect( "/piggyback?target=$target" );
	}
}
