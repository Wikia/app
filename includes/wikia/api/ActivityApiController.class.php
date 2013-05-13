<?php

/** Controller for acquiring information about latest user activity on current wiki */

class ActivityApiController extends WikiaApiController {
	private $revisionService;

	function __construct( $revisionService = null ) {
		if( $revisionService == null ) {
			$revisionServiceFactory = new RevisionServiceFactory();
			$revisionService = $revisionServiceFactory->get();
		}
		$this->revisionService = $revisionService;
	}


	public function getLatestActivity() {

		$items = $this->revisionService->getLatestRevisions();

		$this->setVal( 'items', $items );
		$this->response->setVal( 'basepath', $this->wg->Server );
	}
}
