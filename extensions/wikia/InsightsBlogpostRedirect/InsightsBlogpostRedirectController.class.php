<?php

class InsightsBlogpostRedirectController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Insights', 'insights', true );
	}

	public function index() {
		$this->wg->Out->redirect( wfMessage('insights-blogpost-url')->escaped() );
	}

}
