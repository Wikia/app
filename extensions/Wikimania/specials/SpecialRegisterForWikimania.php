<?php
/**
 * Register for Wikimania
 */
class SpecialRegisterForWikimania extends SpecialPage {
	public function __construct() {
		parent::__construct( 'RegisterForWikimania', 'wikimania-register' );
	}

	public function execute( $par = '' ) {
		$this->setHeaders();
		$this->getOutput()->addModules( 'ext.wikimania' );
		$form = new WikimaniaRegistration( Wikimania::getWikimania(), $this->getContext() );
		$form->show();
	}
}
