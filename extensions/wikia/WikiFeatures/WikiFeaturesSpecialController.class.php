<?php

/**
 * Wiki Features Special Page
 * @author Hyun
 * @author Owen
 *
 */
class WikiFeaturesSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		wfLoadExtensionMessages('WikiFeatures');
		parent::__construct('WikiFeatures', '', false);
	}
	
	public function init() {
		$this->response->addAsset('extensions/wikia/WikiFeatures/js/WikiFeatures.js');
	}
	
	public function index() {
		
	}
	
}
