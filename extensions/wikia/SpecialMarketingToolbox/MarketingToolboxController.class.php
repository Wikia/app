<?php

class MarketingToolboxController extends WikiaSpecialPageController {

	protected $toolboxModel;

	public function __construct() {
		parent::__construct('MarketingToolbox', 'marketingtoolbox', true);
	}

	public function isRestricted() {
		return true;
	}

	public function init() {
        $this->toolboxModel = new MarketingToolboxModel();
	}

	protected function checkAccess() {
		$this->wf->ProfileIn(__METHOD__);

		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('marketingtoolbox') ) {
			$this->wf->ProfileOut(__METHOD__);
			$this->specialPage->displayRestrictionError();
			return false;
		}

		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox.scss');
		$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/MarketingToolbox.js');

		$this->wf->ProfileOut(__METHOD__);
		return true;
	}

	public function index() {
		$this->wf->ProfileIn(__METHOD__);
		$this->wg->Out->setPageTitle(wfMsg('marketing-toolbox-title'));

		if( $this->checkAccess() ) {
			$this->corporateWikisLanguages = $this->toolboxModel->getCorporateWikisLanguages();
			$this->sections = $this->toolboxModel->getAvailableSections();
			$this->verticals = $this->getVerticals(MarketingToolboxModel::SECTION_HUBS);
		}
	}

	/**
	 * @param $timestamp (of start date)
	 * @return array
	 */
	public function getCalendarData($timestamp = null) {
		if(empty($timestamp)) {
			$timestamp = time();
		}
		$this->calendarData = $this->toolboxModel->getData($timestamp);
	}

	/**
	 * Get available verticals for selected Section
	 *
	 * @param int $sectionId
	 * @return array
	 */
	public function getVerticals($sectionId) {
		return $this->toolboxModel->getAvailableVerticals(MarketingToolboxModel::SECTION_HUBS);
	}
}
