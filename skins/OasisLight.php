<?php

class SkinOasisLight extends WikiaSkin {
	public function __construct() {
		parent::__construct( 'OasisLightTemplate', 'oasislight' );
	}
}

class OasisLightTemplate extends WikiaSkinTemplate {
	function execute() {
		if ( !$this->wg->EnableOasisLightExt ) {
			header( 'HTTP/1.0 404 Not Found' );
			return 'Oasis Light skin is disabled';
		}

		$this->app->setSkinTemplateObj( $this );
		$response = $this->app->sendRequest( 'OasisLightController', 'index' );
		$response->sendHeaders();
		$response->render();
	}
}
