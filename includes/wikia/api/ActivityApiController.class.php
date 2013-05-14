<?php

/** Controller for acquiring information about latest user activity on current wiki */

class ActivityApiController extends WikiaApiController {
	private $revisionService;

	function __construct( $revisionService = null ) {
		if( $revisionService == null ) {
			$revisionService = new RevisionService();
		}
		$this->revisionService = $revisionService;
	}

	/**
	 * Fetches latest activity information
	 *
	 * @responseParam array latest revision information
	 *
	 * @example
	 */
	public function getLatestActivity() {
		$limit = $this->getRequest()->getInt("limit", 10);
		$namespaces = $this->getRequest()->getArray("namespaces", array("0", "14"));
		$categories = $this->getRequest()->getArray("categories", null);
		$allowDuplicates = $this->getRequest()->getBool("allowDuplicates", false);

		$items = $this->revisionService->getLatestRevisions($limit, $namespaces, $categories, $allowDuplicates);

		$this->setVal( 'items', $items );
		$this->response->setVal( 'basepath', $this->wg->Server );
	}
}
