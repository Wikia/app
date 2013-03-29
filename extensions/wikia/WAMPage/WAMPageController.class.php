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
	}

	public function index() {
		$faqPageName = $this->model->getWAMFAQPageName();

		$title = $this->wg->Title;
		if( $title instanceof Title ) {
			$this->subpageText = $title->getSubpageText();
			$currentTabIndex = $this->model->getTabIndexBySubpageText($this->subpageText);
			
			$this->redirectIfFirstTab($currentTabIndex, $this->subpageText);
		}
		
		$this->faqPage = !empty($faqPageName) ? $faqPageName : '#';
		$this->tabs = $this->model->getTabs($currentTabIndex);
		$this->visualizationWikis = $this->model->getVisualizationWikis($currentTabIndex);
		$this->indexWikis = $this->model->getIndexWikis();
	}
	
	protected function redirectIfFirstTab($tabIndex, $subpageText) {
		$isFirstTab = ($tabIndex === WAMPageModel::TAB_INDEX_TOP_WIKIS && !empty($subpageText));
		$mainWAMPageUrl = $this->model->getWAMMainPageUrl();
		
		if( $isFirstTab && !empty($mainWAMPageUrl) ) {
			$this->wg->Out->redirect($mainWAMPageUrl, HTTP_REDIRECT_PERM);
		}
	}
	
	public function faq() {
		//just for the template now...
	}
}
