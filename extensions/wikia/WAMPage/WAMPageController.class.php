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

		$this->filterLanguages = $this->model->getCorporateWikisLanguages();
		$this->filterVerticals = $this->model->getVerticals();
	}

	protected function getIndexParams() {
		$this->searchPhrase = $this->getVal('searchPhrase', null);
		$this->selectedVerticalId = $this->getVal('verticalId', null);
		$this->selectedLangCode = $this->getVal('langCode', null);
		$this->selectedDate = $this->getVal('date', null);

		// TODO validation

		$indexParams = [
			'searchPhrase' => $this->searchPhrase,
			'verticalId' => $this->selectedVerticalId,
			'langCode' => $this->selectedLangCode,
			'date' => $this->selectedDate
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
