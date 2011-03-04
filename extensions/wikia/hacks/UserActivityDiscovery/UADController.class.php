<?php

class UADController extends WikiaController {

	const COOKIE_NAME = 'UAD';

	/**
	 * @var WikiaApp
	 */
	protected $app = null;
	/**
	 * @var UAD
	 */
	protected $UAD = null;
	protected $cookie = null;

	public function __construct(WikiaApp $app, UAD $uad) {
		$this->allowedRequests[ 'store' ] = array( 'json' );
		$this->allowedRequests[ 'index' ] = array( 'json' );

		$this->app = $app;
		$this->UAD = $uad;
	}

	public function index() {
		$this->store();
	}

	protected function fetchCookie() {
		$this->cookie = array( 'token' => null, 'date' => date('Y-m-d'), 'events' => array( 1 => array( 'type' => 'VISIT' ) ) );
		// @todo disabled until fronted will be ready
		//$this->cookie = $this->app->getCookie( self::COOKIE_NAME );
		if( empty($this->cookie) ) {
			throw new WikiaException('UAD Cookie not found');
		}
	}

	protected function fetchEventsFromCookie( $token ) {
		$events = $this->cookie[ 'events' ];
		$date = $this->cookie[ 'date' ];
		$this->UAD->storeEvents( $token, $date, $events );
		$this->purgeEventsFromCookie();
	}

	protected function purgeEventsFromCookie() {
		$this->cookie[ 'events' ] = array();
		// @todo disabled until fronted will be ready
		//$this->app->setCookie( self::COOKIE_NAME, $this->cookie );
	}

	public function store() {
		$this->fetchCookie();

		$token = $this->cookie['token'];
		if(empty($token)) {
			$token = $this->UAD->createToken();
		}

		$events = $this->fetchEventsFromCookie( $token );

		$this->getResponse()->setVal( 'token', $token );
	}

	public function onOutputPageBeforeHTML( &$out, &$text ) {
		$wgJsMimeType = $this->app->getGlobal('wgJsMimeType');
		$wgExtensionsPath = $this->app->getGlobal('wgExtensionsPath');
		$wgStyleVersion = $this->app->getGlobal('wgStyleVersion');

		$out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/hacks/UserActivityDiscovery/js/uad.js?{$wgStyleVersion}\"></script>\n" );

		return true;
	}


}