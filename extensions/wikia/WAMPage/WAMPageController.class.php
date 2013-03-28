<?php

class WAMPageController extends WikiaController
{
	protected $model;

	public function __construct() {
		parent::__construct( 'WAMPage', '', false );

		$this->model = new WAMPageModel();
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
	}
	
	public function faq() {
		//just for the template now...
	}
}
