<?php

class ActiveNewWikisController extends WikiaSpecialPageController {

		public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( NewWikisController::SPECIAL_PAGE_NAME1, '', false );
	}

	/**
	 * we can't register one controller for two special pages so we simply proxying everything
	 */
	public function index() {
		$this->forward( 'NewWikis', 'getActive' );
	}
}