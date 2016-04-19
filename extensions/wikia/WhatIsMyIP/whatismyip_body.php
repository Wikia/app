<?php

if ( !defined( 'MEDIAWIKI' ) )
{
	echo "This is MediaWiki extension named WhatIsMyIP.\n";
	exit( 1 ) ;
}

class WhatIsMyIP extends SpecialPage
{
	function  __construct() {
		parent::__construct( 'WhatIsMyIP' /*class*/ );
	}

	function execute ( $par )
	{
		global $wgOut;
		$wgOut->SetPageTitle( wfMsg( 'whatismyip' ) );
		$ip = $this->getRequest()->getIP();
		$wgOut->addWikiMsg( 'whatismyip_out', $ip );
	}
}
