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
		$this->faqPage = !empty($this->app->wg->WAMPageConfig['faqPageName']) ? $this->app->wg->WAMPageConfig['faqPageName'] : '#';

		$this->visualizationWikis = $this->model->getVisualizationWikis($this->wg->ContLang->getCode());
	}
	
	public function faq() {
		//just for the template now...
	}
}
