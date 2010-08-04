<?php

class ImageServingTest extends SpecialPage {
	function __construct() {
		global $wgRequest;
		parent::__construct( 'ImageServingTest', 'imageservingtest' );
		wfLoadExtensionMessages( 'ImageServingTest' );
	}

	function execute( $par ){
		global $wgRequest, $wgOut, $wgUser;
		$test = new imageServing(array(6036));
		$test->getImages(7);
	}
}