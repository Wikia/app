<?php

/**
 * ParserSpeed special page
 * @author wladek
 */

class ParserSpeedSpecialPageController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'ParserSpeed', '', false );
	}

	/**
	 * this is default method, which in this example just redirects to helloWorld method
	 */
	public function index() {
		// access control
		if ( !$this->wg->User->isAllowed( 'parserspeed' ) ) {
			$this->displayRestrictionError();
			return false;
		}


		$pager = new ParserSpeedTablePager();
		$this->setVal('body',$pager->getBody());
		$this->setVal('nav',$pager->getNavigationBar());

	}

}
