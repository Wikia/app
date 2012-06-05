<?php

class SpecialAbTestingController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('AbTesting', 'abtestpanel', false);
	}

	function index() {
		if ( !$this->wg->User->isAllowed( 'abtestpanel' ) ) {
			$this->wg->Out->permissionRequired( 'abtestpanel' );
			$this->skipRendering();
			return;
		}

		$this->setHeaders();

		// TODO: Set up other variables for the template.
		
	}
	
	function createExperiment() {
	
		$this->expName = 'test name';
		
	
	}
}
