<?php

class SpecialPortabilityDashboardController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'PortabilityDashboard', 'pidash', true );
	}

	public function index() {
		$model = new PortabilityDashboardModel();
		$this->response->setVal( 'list', $model->getList() );
	}

}
