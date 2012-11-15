<?php

class MarketingToolboxController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('MarketingToolbox', 'marketingtoolbox', true);
	}

	public function isRestricted() {
		return true;
	}

	public function init() {
	}

	protected function checkAccess() {
		$this->wf->ProfileIn(__METHOD__);

		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('marketingtoolbox') ) {
			$this->wf->ProfileOut(__METHOD__);
			$this->overrideTemplate('onWrongRights');
			return false;
		}

		$this->wf->ProfileOut(__METHOD__);
		return true;
	}

	public function index() {
		$this->wf->ProfileIn(__METHOD__);
		$this->wg->Out->setPageTitle(wfMsg('marketing-toolbox-title'));

		if( $this->checkAccess() ) {

		}
	}



}
