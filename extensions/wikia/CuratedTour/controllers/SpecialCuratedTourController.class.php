<?php

class SpecialCuratedTourController extends WikiaSpecialPageController {

	function __construct() {
		parent::__construct( 'CuratedTour', 'curated tour', true );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMessage( 'curated-tour-page-title' )->escaped() );
	}
}
