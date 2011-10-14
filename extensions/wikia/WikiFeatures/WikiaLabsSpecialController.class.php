<?php

/**
 * Wikia Labs redirect
 * @author Hyun
 */
class WikiaLabsSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('WikiaLabs', '', false);
	}
	
	public function init() {
		
	}
	
	public function index() {
		$wikiFeaturesUrl = Title::newFromText('WikiFeatures', NS_SPECIAL)->getFullURL();
		$this->wg->Out->enableClientCache(false);
		$this->wg->Out->redirect($wikiFeaturesUrl, '301');
	}
	
}