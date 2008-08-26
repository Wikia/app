<?php

if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension named WhatIsMyIP.\n";
	exit(1);
}

class WhatIsMyIP extends SpecialPage {
	function  __construct() {
		parent::__construct('WhatIsMyIP' /*class*/);
	}

	function WhatIsMyIP(){
		SpecialPage::SpecialPage( 'WhatIsMyIP', 'whatismyip' );
	}

	function execute(){
		global $wgOut;

		wfLoadExtensionMessages('WhatIsMyIP');

		$wgOut->setPageTitle(wfMsg('whatismyip'));
		// $wgOut->addWikiText( wfMsg('whatismyip-username'). " $user" );
		$ip = wfGetIP();
		$wgOut->addWikiText( wfMsg('whatismyip-out'). " $ip" );
	}
}
