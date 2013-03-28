<?php

class WAMPageController extends WikiaController
{
	protected $model;
	protected $tabIndex;

	public function __construct() {
		parent::__construct( 'WAMPage', '', false );

		$this->model = new WAMPageModel();
		// MOCKED tab index
		$this->tabIndex = 0;
	}

	public function init() {
		$this->response->addAsset('wampage_scss');
		$this->response->addAsset('wampage_js');
	}

	public function index() {
		$faqPageName = $this->model->getWAMFAQPageName();

		$currentTabIndex = 0;
		$title = $this->wg->Title;
		if( $title instanceof Title ) {
			$currentTabIndex = $this->model->getTabIndexBySubpageText( $title->getSubpageText() );
		}
		
		$this->faqPage = !empty($faqPageName) ? $faqPageName : '#';
		$this->tabs = $this->model->getTabs($currentTabIndex);
		$this->visualizationWikis = $this->model->getVisualizationWikis($this->wg->ContLang->getCode());
		$this->indexWikis = $this->model->getIndexWikis();
	}
	
	public function faq() {
		//just for the template now...
	}
}
