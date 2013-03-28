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
		$this->faqPage = !empty($this->app->wg->WAMPageConfig['faqPageName']) ? $this->app->wg->WAMPageConfig['faqPageName'] : '#';
		$this->tabs = $this->model->getTabs();

		$this->visualizationWikis = $this->model->getVisualizationWikis();

		$this->indexWikis = $this->model->getIndexWikis();
	}
	
	public function faq() {
		//just for the template now...
	}
}
