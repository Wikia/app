<?php

class Piggyback extends SpecialPage {

	private $logger;
	private $redirectHelper;

	function __construct() {
		parent::__construct( 'Piggyback', 'piggyback' );
		$this->logger = Wikia\Logger\WikiaLogger::instance();
		$this->redirectHelper = new AuthPageRedirectHelper( $this->getOutput() );
	}

	function execute( $par ) {
		$this->logger->info( 'IRIS-4219 Piggyback has been rendered' );
		$this->redirectHelper->redirectToPiggyback( $this->getTarget() );
	}

	private function getTarget() {
		if ( !empty( $par ) ) {
			return $par;
		} else {
			return $this->getRequest()->getVal( 'target' );
		}
	}
}
