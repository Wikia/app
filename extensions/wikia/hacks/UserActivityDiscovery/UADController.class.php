<?php

class UADController extends WikiaController {

	const COOKIE_NAME = 'UADtracker';
	const COOKIE_LIFESPAN = 7776000;

	/**
	 * @var WikiaApp
	 */
	protected $app = null;
	/**
	 * @var UAD
	 */
	protected $UAD = null;
	protected $cookie = null;

	public function __construct() {
		$this->allowedRequests[ 'store' ] = array( 'json' );
		$this->allowedRequests[ 'index' ] = array( 'json' );

		$this->app = F::app();
		$this->UAD = new UAD();
	}

	public function index() {
		$this->store();
	}

	protected function fetchCookie() {
		//$this->cookie = array( 'token' => null, 'date' => date('Y-m-d'), 'events' => array( 1 => array( 'type' => 'VISIT' ) ) );
		$this->cookie = json_decode( $this->app->getCookie( self::COOKIE_NAME ) );
		if( empty($this->cookie) ) {
			throw new WikiaException('UAD Cookie not found');
		}
	}

	protected function fetchEventsFromCookie( $token ) {
		$events = $this->cookie->events;
		$date = $this->cookie->date;
		$this->UAD->storeEvents( $token, $date, $events );
		$this->purgeEventsFromCookie();
	}

	protected function purgeEventsFromCookie() {
		$this->cookie->events = new stdClass();
	}

	protected function setTokenInCookie( $token ) {
		$this->cookie->token = $token;
	}

	protected function updateCookie() {
		$this->app->setCookie( self::COOKIE_NAME, json_encode( $this->cookie ), ( time() + self::COOKIE_LIFESPAN ) );
	}

	public function store() {
		$this->fetchCookie();

		if( !isset( $this->cookie->token ) ) {
			$token = $this->UAD->createToken();
			$this->setTokenInCookie( $token );
		}
		else {
			$token = $this->cookie->token;
		}

		//$events = $this->fetchEventsFromCookie( $token );

		$this->getResponse()->setVal( 'token', $token );
		$this->updateCookie();
	}

	public function onOutputPageBeforeHTML( &$out, &$text ) {
		$wgJsMimeType = $this->app->getGlobal('wgJsMimeType');
		$wgExtensionsPath = $this->app->getGlobal('wgExtensionsPath');

		$out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/hacks/UserActivityDiscovery/js/uad.js\"></script>\n" );

		return true;
	}


}