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
			$currentTabIndex = $this->model->getTabIndexBySubpageText( $title->getSubpageText() );
		}
		
		$this->faqPage = !empty($faqPageName) ? $faqPageName : '#';
		$this->tabs = $this->model->getTabs($currentTabIndex);
		$this->visualizationWikis = $this->model->getVisualizationWikis($currentTabIndex);
		$this->indexWikis = $this->model->getIndexWikis();
	}
	
	public function faq() {
		//just for the template now...
	}
}
