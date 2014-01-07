<?php

/**
 * ParserSpeed special page
 * @author wladek
 */

class ParserSpeedSpecialPageController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'ParserSpeed', 'parserspeed', false );
	}

	public function index() {
		// access control
		if ( !$this->wg->User->isAllowed( 'parserspeed' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		$this->specialPage->setHeaders();

		$pager = new ParserSpeedTablePager();
		$this->setVal('body',$pager->getBody());
		$this->setVal('nav',$pager->getNavigationBar());
	}

}
