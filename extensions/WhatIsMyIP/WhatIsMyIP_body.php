<?php
/**
 * Main class for WhatIsMyIP
 * @file
 * @ingroup Extensions
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named WhatIsMyIP.\n";
	exit( 1 );
}

class WhatIsMyIP extends SpecialPage {

	/**
	 * Constructor
	 */
	public function  __construct() {
		parent::__construct( 'WhatIsMyIP'/*class*/, 'whatismyip'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut;

		wfLoadExtensionMessages( 'WhatIsMyIP' );

		$wgOut->setPageTitle( wfMsg( 'whatismyip' ) );
		$ip = wfGetIP();
		$wgOut->addWikiText( wfMsg( 'whatismyip-out' ) . " $ip" );
	}
}
