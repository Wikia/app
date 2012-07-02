<?php

class SpecialResourceLoaderTests extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ResourceLoaderTests', 'resourceloadertests' );
	}

	public function execute( $par ) {
		global $wgOut;
		
		$wgOut->addModules( 'ext.resourceLoaderTests.a' );
		
		$this->setHeaders();
		
		$wgOut->addHtml( '<a id="resourceloadertests-load-b" href="#">Load B</a>' );
	}
}
