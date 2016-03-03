<?php

class SpecialFounderEmails extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'FounderEmails', 'founderemails' );
	}

	public function execute( $par ) {
		Wikia::setVar( 'OasisEntryControllerName', 'FounderEmails' );
	}

}