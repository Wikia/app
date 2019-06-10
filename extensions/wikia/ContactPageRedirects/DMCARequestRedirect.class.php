<?php

class DMCARequestRedirect extends UnlistedSpecialPage {
	private $redirectTarget = 'https://fandom.zendesk.com/';

	public function  __construct() {
		parent::__construct( 'DMCARequest' );
	}

	public function execute( $subpage ) {
		$this->getOutput()->redirect( $this->redirectTarget, '301' );
	}
}
