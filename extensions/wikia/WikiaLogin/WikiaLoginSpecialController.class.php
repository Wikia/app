<?php

/**
 * WikiaLogin Special Page
 * @author Hyun
 * @author Saipetch
 *
 */
class WikiaLoginSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		wfLoadExtensionMessages('WikiaLogin');
		parent::__construct('WikiaLogin', '', false);
	}
	
	public function init() {
		$this->response->addAsset('extensions/wikia/WikiaLogin/js/WikiaLogin.js');
	}
	
	public function index() {
		
	}
	
}
