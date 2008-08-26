<?php

class MakeDBErrorPage extends UnlistedSpecialPage
{
	function MakeDBErrorPage() {
		UnlistedSpecialPage::UnlistedSpecialPage("MakeDBError");
	}

	function execute( $par ) {
		global $wgOut;
		$this->setHeaders();
		if ( $par == 'connection' ) {
			$lb = wfGetLB();
			$lb->mServers[1234] = $lb->mServers[0];
			$lb->mServers[1234]['user'] = 'chicken';
			$lb->mServers[1234]['password'] = 'cluck cluck';
			$db =& wfGetDB( 1234 );
			$wgOut->addHTML("<pre>" . var_export( $db, true ) . "</pre>" );
		} else {
			$db =& wfGetDB( DB_SLAVE );
			$db->query( "test" );
		}
	}
}


