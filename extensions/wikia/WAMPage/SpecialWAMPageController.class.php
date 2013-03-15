<?php

class SpecialWAMPageController extends WikiaSpecialPageController
{
	public function __construct() {
		parent::__construct( 'WAMPage', '', false );
	}

	public function init() {

	}

	public function index() {
		$this->response->addAsset('wampage_scss');
		$this->response->addAsset('wampage_js');
	}
	
	public function faq() {
		//just for the template now...
	}
}
