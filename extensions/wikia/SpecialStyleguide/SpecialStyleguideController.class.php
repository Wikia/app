<?php

class SpecialStyleguideController extends WikiaSpecialPageController {

	public function __construct () {
		parent::__construct( 'Styleguide' );
	}

	public function index () {
		wfProfileIn(__METHOD__);
		RenderContentOnlyHelper::setRenderContentVar(true);
		$this->wg->Out->clearHTML();
		$this->wg->Out->setPageTitle( wfMessage( 'styleguide-pagetitle' )->text() );

		// skip rendering
		return false;
	}
}
