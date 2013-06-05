<?php

class SpecialStyleguideController extends WikiaSpecialPageController {

	public function __construct () {
		parent::__construct( 'Styleguide' );
	}

	public function index () {
		wfProfileIn(__METHOD__);
		RenderContentOnlyHelper::setRenderContentVar(true);
		$this->wg->Out->clearHTML();

		// skip rendering
		return false;
	}
}
