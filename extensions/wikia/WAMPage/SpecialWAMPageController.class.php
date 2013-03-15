<?php

class SpecialWAMPageController extends WikiaSpecialPageController
{
	public function __construct() {
		parent::__construct( 'WAMPage', '', false );
	}

	public function init() {
		$this->response->addAsset('wampage_scss');
	}

	public function index() {
		//just for the template now...
	}
	
	public function faq() {
		//just for the template now...
	}
}
