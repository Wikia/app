<?php
if ( !defined( 'MEDIAWIKI' ) ) { 
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ; 
}

class WikiFactoryRedirPage extends UnlistedSpecialPage {
	function  __construct() {
		parent::__construct( "WikiFactory"  /*class*/, '' /*restriction*/);
	}

	public function execute( $subpage ) {
		global $wgOut;

		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		global $wgDBname;
		// $wgOut->addHtml( 'The dbname of this wiki is ['. $wgDBname ."]<br/>\n" );

		$WF = GlobalTitle::newFromText('WikiFactory/db:'. $wgDBname, NS_SPECIAL, 177);
		$url = $WF->getFullURL();

		$wgOut->redirect( $url );
	}

}
