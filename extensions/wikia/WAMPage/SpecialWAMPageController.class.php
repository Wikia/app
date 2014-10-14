<?php

class SpecialWAMPageController extends WikiaSpecialPageController
{
	public function __construct() {
		parent::__construct( 'WAMPage', '', false );
	}

	public function init() {
		$this->response->addAsset('wampage_scss');
		$this->response->addAsset('wampage_js');
	}

	public function index() {
		$this->faqPage = !empty($this->app->wg->WAMPageConfig['faqPageName']) ? $this->app->wg->WAMPageConfig['faqPageName'] : '#';
	}
	
	public function faq() {
		//just for the template now...
	}
}
