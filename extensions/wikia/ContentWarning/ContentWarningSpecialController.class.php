<?php

/**
 * Content Warning Special Page
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ContentWarningSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('ContentWarning', '', false);
	}

	public function init() {
		$this->response->addAsset('extensions/wikia/ContentWarning/js/ContentWarning.js');
		$this->response->addAsset('extensions/wikia/ContentWarning/css/ContentWarning.scss');
	}

	public function index() {
		
	}

}
