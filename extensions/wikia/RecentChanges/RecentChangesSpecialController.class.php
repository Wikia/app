<?php

/**
 * Recent Changes Special Page
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class RecentChangesSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('RecentChanges', '', false);
	}

	public function init() {
		$this->response->addAsset('extensions/wikia/RecentChanges/js/RecentChanges.js');
		$this->response->addAsset('extensions/wikia/RecentChanges/css/RecentChanges.scss');
	}

	public function index() {
		
	}

}
