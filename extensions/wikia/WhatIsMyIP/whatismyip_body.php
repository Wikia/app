<?php

if (!defined('MEDIAWIKI')) 
{
	echo "This is MediaWiki extension named WhatIsMyIP.\n";
	exit(1) ;
}

global $wgMessageCache, $wgOut;
$wgMessageCache->addMessage( "whatismyip", "What is my IP" );
$wgMessageCache->addMessage( "whatismyip_out", "Your IP: $1" );

class WhatIsMyIP extends SpecialPage 
{
	function  __construct() {
		parent::__construct('WhatIsMyIP' /*class*/);
	} 

	function WhatIsMyIP() 
	{
		SpecialPage::SpecialPage( 'WhatIsMyIP', 'whatismyip' );
	}

	function execute () 
	{
		global $wgMessageCache, $wgOut;
		$wgOut->SetPageTitle(wfMsg('whatismyip'));
		$ip = wfGetIP();
		$wgOut->addWikiMsg( 'whatismyip_out', $ip );
	}
}
