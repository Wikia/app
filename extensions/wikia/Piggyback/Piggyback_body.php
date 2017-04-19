<?php

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Auth\CookieHelper;

class Piggyback extends SpecialPage {

	private $logger;

	function __construct() {
		parent::__construct( 'Piggyback', 'piggyback' );
		$this->logger = Wikia\Logger\WikiaLogger::instance();
	}

	function execute( $par ) {
		$this->logger->info( 'IRIS-4219 Piggyback has been rendered' );

		if ( !empty( $par ) ) {
			$this->getRequest()->setVal( 'target', $par );
		}

		$this->redirectToMercuryPiggyback( $this->getOutput(),
			$this->getRequest()->getVal( 'target' ) );
	}

	private function redirectToMercuryPiggyback( OutputPage $out, $target ) {
		$redirectUrl = '/piggyback';
		if ( !empty( $target ) ) {
			$redirectUrl .= sprintf( "?target=%s", $target );
		}
		$out->redirect( $redirectUrl );
		$this->clearBodyAndSetMaxCache( $out );
	}

	/**
	 * @param OutputPage $out
	 */
	public function clearBodyAndSetMaxCache( OutputPage $out ) {
		$out->setArticleBodyOnly( true );
		$out->setSquidMaxage( WikiaResponse::CACHE_LONG );
	}

}
