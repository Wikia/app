<?php
class VenusTestController extends WikiaSpecialPageController {
	protected  $model;

	public function __construct() {
		parent::__construct('VenusTest', '', false);
	}

	/**
	 * Main page for Special:VenusTest page
	 * 
	 * @return boolean
	 */
	public function index() {
		if( $this->checkPermissions() ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->title = 'Venus Skin test';

		return true;
	}
}
