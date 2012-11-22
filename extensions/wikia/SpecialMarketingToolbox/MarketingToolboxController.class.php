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

			$userPreferendesHandler = new MarketingToolboxUserPropertiesHandler();
			$selectedLanguageObject = $userPreferendesHandler->getMarketingToolboxRegion();
			$this->selectedLanguage = $selectedLanguageObject->propertyValue;
			$selectedVerticalObject = $userPreferendesHandler->getMarketingToolboxVertical();
			$this->selectedVertical = $selectedVerticalObject->propertyValue;


			$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/css/MarketingToolbox.scss');
			$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/MarketingToolbox.js');
			$this->response->addAsset('/extensions/wikia/SpecialMarketingToolbox/js/DatepickerModel.js');

			F::build('JSMessages')->enqueuePackage('MarketingToolbox', JSMessages::EXTERNAL);
		}

		$this->wf->ProfileOut(__METHOD__);
	}

	/**
	 * Get calendar for actual and following 2 months
	 *
	 * @param $timestamp (actual timestamp)
	 * @return array
	 */
	public function getCalendarData() {
		$langId = $this->getVal('langId');
		$verticalId = $this->getVal('verticalId');
		$beginTimestamp = $this->getVal('beginTimestamp', time());
		$endTimestamp = $this->getVal('endTimestamp', time());
		$this->calendarData = $this->toolboxModel->getData($langId, $verticalId, $beginTimestamp, $endTimestamp);
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
