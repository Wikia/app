<?php

class WAMPageController extends WikiaController
{
	protected $model;

	public function __construct() {
		parent::__construct();

		$this->model = new WAMPageModel();
	}

	public function init() {
		$this->response->addAsset('wampage_scss');
		$this->response->addAsset('wampage_js');

		OasisController::addBodyClass('WAMPage');
	}

	public function index() {
		$this->response->addAsset('/skins/oasis/css/modules/CorporateDatepicker.scss');
		$this->collectRequestParameters();

		$faqPageName = $this->model->getWAMFAQPageName();

		$title = $this->wg->Title;
		if( $title instanceof Title && $title->isSubpage() ) {
			$this->subpageText = $title->getSubpageText();
			$currentTabIndex = $this->model->getTabIndexBySubpageText($this->subpageText);
			
			$this->redirectIfFirstTab($currentTabIndex, $this->subpageText);
		} else {
			$currentTabIndex = WAMPageModel::TAB_INDEX_TOP_WIKIS;
			$this->subpageText = $this->model->getTabNameByIndex($currentTabIndex);
		}

		$this->faqPage = !empty($faqPageName) ? $faqPageName : '#';
		$this->tabs = $this->model->getTabs($currentTabIndex);
		$this->visualizationWikis = $this->model->getVisualizationWikis($currentTabIndex);

		$this->indexWikis = $this->model->getIndexWikis($this->getIndexParams());
	}

	protected function collectRequestParameters() {
		$this->filterLanguages = $this->model->getCorporateWikisLanguages();
		$this->filterVerticals = $this->model->getVerticals();

		$this->searchPhrase = $this->getVal('searchPhrase', null);
		$this->selectedVerticalId = $this->getVal('verticalId', null);
		$this->selectedLangCode = $this->getVal('langCode', null);
		$this->selectedDate = $this->getVal('date', null);

		$this->selectedVerticalId = ($this->selectedVerticalId !== '') ? $this->selectedVerticalId : null;
		$this->selectedLangCode = ($this->selectedLangCode !== '') ? $this->selectedLangCode : null;
		$this->selectedDate = ($this->selectedDate !== '') ? $this->selectedDate : null;

		$langValidator = new WikiaValidatorSelect(array('allowed' => $this->filterLanguages));
		if (!$langValidator->isValid($this->selectedLangCode)) {
			$this->selectedLangCode = null;
		}
		$verticalValidator = new WikiaValidatorSelect(array('allowed' => array_keys($this->filterVerticals)));
		if (!$verticalValidator->isValid($this->selectedVerticalId)) {
			$this->selectedVerticalId = null;
		}

		// TODO add date validator - depanding on min and max date from WAM api
		// TODO add min and max date on calendar
	}

	protected function getIndexParams() {
		$indexParams = [
			'searchPhrase' => $this->searchPhrase,
			'verticalId' => $this->selectedVerticalId,
			'langCode' => $this->selectedLangCode,
			'date' => isset($this->selectedDate) ? strtotime($this->selectedDate) : null
		];
		return $indexParams;
	}
	
	protected function redirectIfFirstTab($tabIndex, $subpageText) {
		$isFirstTab = ($tabIndex === WAMPageModel::TAB_INDEX_TOP_WIKIS && !empty($subpageText));
		$mainWAMPageUrl = $this->model->getWAMMainPageUrl();
		
		if( $isFirstTab && !empty($mainWAMPageUrl) ) {
			$this->wg->Out->redirect($mainWAMPageUrl, HTTP_REDIRECT_PERM);
		}
	}
	
	public function faq() {
		$this->wamPageUrl = $this->model->getWAMMainPageUrl();
	}
}
