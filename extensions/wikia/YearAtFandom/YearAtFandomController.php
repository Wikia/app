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
		$userId = $this->getVal( 'userId' );

		$this->getResponse()->setBody(\GuzzleHttp\json_encode( $this->provider->getAll( $userId ) ));
	}
}
