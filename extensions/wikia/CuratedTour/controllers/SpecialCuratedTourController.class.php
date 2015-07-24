<?php

class SpecialCuratedTourController extends WikiaSpecialPageController {

	function __construct() {
		parent::__construct( 'CuratedTour', 'CuratedTour', true );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMessage( 'curated-tour-page-title' )->escaped() );
		$response = $this->requestGetCuratedTourData()->getData();
		$this->pageTour = $response['data'];
		$this->hasAdminPermissions = $this->wg->User->isAllowed( 'curated-tour-administration' );
	}

	private function requestGetCuratedTourData() {
		return $this->sendRequest( 'CuratedTourController',
			'getCuratedTourData'
		);
	}
}
