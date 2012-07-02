<?php
/* 
 * Administration UI for Wikimania
 */
class SpecialAdministerWikimania extends SpecialPage {
	public function __construct() {
		parent::__construct( 'AdministerWikimania', 'wikimania-admin' );
	}

	public function execute( $par = '' ) {
		$this->setHeaders();
		$this->getOutput()->addHTML( '<p>Todo</p>' );
	}
}
