<?php

class ImageServingTest extends SpecialPage {
	function __construct() {
		global $wgRequest;
		parent::__construct( 'ImageServingTest', 'imageservingtest' );
		wfLoadExtensionMessages( 'ImageServingTest' );
	}

	function execute( $par ){
		global $wgRequest, $wgOut, $wgUser;
		$wgOut->addHtml( "SSS SSSAA" );
	}
}