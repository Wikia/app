<?php

/**
 * Discussion user log page
 */
class SpecialPyrkonScavengerHuntController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'Pyrkon', '', false );
	}

	public function index() {
		\Wikia::addAssetsToOutput( 'pyrkon_results_js' );
	}
}
