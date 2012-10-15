<?php
/**
 * Check your registration status
 */
class SpecialCheckWikimaniaStatus extends SpecialPage {
	public function __construct() {
		parent::__construct( 'CheckWikimaniaStatus', 'wikimania-checkstatus' );
	}

	public function execute( $par = '' ) {
		$this->setHeaders();
		$this->getOutput()->addHTML( '<p>Todo</p>' );
	}
}
