<?php

/**
 * Recent Changes Controller
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class RecentChangesController extends WikiaController {

	public function init() {
		$this->response->addAsset('extensions/wikia/RecentChanges/js/RecentChanges.js');
		$this->response->addAsset('extensions/wikia/RecentChanges/css/RecentChanges.scss');
	}

	public function index() {
		
	}

}
