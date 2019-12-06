<?php

declare( strict_types=1 );

final class YearAtFandomController extends WikiaApiController {

	/** @var YearAtFandomDataProvider */
	private $provider;

	public function __construct() {
		parent::__construct();

		$this->provider = new YearAtFandomDataProvider();
	}

	public function get() {
		$userId = (int) $this->getVal( 'userId' );

		$this->response->setHeader('Access-Control-Allow-Origin', '*' );

		$this->getResponse()->setBody(\GuzzleHttp\json_encode( $this->provider->getAll( $userId ) ));
	}
}
