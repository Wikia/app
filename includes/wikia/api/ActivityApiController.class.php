<?php

/** Controller for acquiring information about latest user activity on current wiki */

class ActivityApiController extends WikiaApiController {

	public function getLatestActivity() {

		$items = RevisionService::getLatestRevisions();

		$this->setVal( 'items', $items );
		$this->response->setVal( 'basepath', $this->wg->Server );
	}
}
