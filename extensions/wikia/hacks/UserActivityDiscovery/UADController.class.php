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

	public function __construct(WikiaApp $app, UAD $uad) {
		$this->allowedRequests[ 'store' ] = array( 'json' );
		$this->allowedRequests[ 'index' ] = array( 'json' );

		$this->app = $app;
		$this->UAD = $uad;
	}

	public function index() {
		$this->store();
	}

	protected function fetchEventsFromCookie() {
		$cookie = $this->app->getCookie( self::COOKIE_NAME );
		if(empty($cookie)) {
			throw new WikiaException('UAD Cookie not found');
		}
		else {
			$events = $cookie[ 'events' ];
			$this->purgeEventsFromCookie( $cookie );

			return $events;
		}
	}

	protected function purgeEventsFromCookie( $cookie ) {
		$cookie[ 'events' ] = array();
		$this->app->setCookie( self::COOKIE_NAME, $cookie );
	}

	public function store() {
		$token = $this->getRequest()->getVal('token');
		if(empty($token)) {
			$token = $this->UAD->createToken();
		}

		$events = $this->fetchEventsFromCookie();

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