<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Special404 extension\n";
	exit( 1 );
}

class Special404 extends UnlistedSpecialPage {
	
	public function __construct() {
		parent::__construct('Error404');
	}
	
	public function execute( $par ) {
		global $wgOut, $wgRequest, $egSpecial404RedirectExistingRoots;
		
		if ( $egSpecial404RedirectExistingRoots ) {
			$t = null;
			$titles = array(
				$wgRequest->getRequestURL(),
				trim($wgRequest->getRequestURL(), '/\\'),
				urldecode($wgRequest->getRequestURL()),
				urldecode(trim($wgRequest->getRequestURL(), '/\\')),
			);
			foreach ( $titles as $pageTitle ) {
				$t = Title::newFromText($pageTitle);
				if ( is_object($t) && $t->exists() ) {
					$wgOut->redirect( $t->getFullURL(), 301 );
					return;
				}
			}
		}
		
		$this->setHeaders();
		$wgOut->setStatusCode( 404 );
		$wgOut->addWikiMsg( 'special404-body', trim($wgRequest->getRequestURL(), '/\\') );
		
	}
	
}
