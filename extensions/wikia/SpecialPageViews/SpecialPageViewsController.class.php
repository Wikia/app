<?php

class SpecialPageViewsController extends WikiaSpecialPageController {

	const SPECIALPAGE_NAME = 'PageViews';

	function __construct() {
		parent::__construct( self::SPECIALPAGE_NAME );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		wfProfileOut( __METHOD__ );
	}
}
