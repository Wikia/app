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
	}
	
	public function faq() {
		//just for the template now...
	}
}
