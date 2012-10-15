<?php

/**
 * WikiaStyleGuide controller
 * @brief This special page is to demo Wikia's UI Styleguide elements
 * @author Hyun Lim
 */
 
class WikiaStyleGuideSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'WikiaStyleGuide', '', false );
	}

	public function init() {
	}
	
	public function index() {
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;
		$this->wg->SuppressAds = true;
		$this->wg->SuppressToolbar = true;
	}
	
	public function ajaxModalSample() {
	}

}