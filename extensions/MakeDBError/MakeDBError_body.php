<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point\n" );
}

class SpecialMakeDBError extends UnlistedSpecialPage
{
	function __construct() {
		parent::__construct("MakeDBError");
	}

	function execute( $par ) {
		global $wgOut;
		$this->setHeaders();
		if ( $par == 'connection' ) {
			$lb = wfGetLB();
			$failServer = $lb->getServerInfo( 0 );
			$failServer['user'] = 'chicken';
			$failServer['password'] = 'cluck cluck';
			$lb->setServerInfo ( 1234, $failServer ); /* What happens when there *are* actually >1234 servers? */
			$db = wfGetDB( 1234 );
			$wgOut->addHTML("<pre>" . var_export( $db, true ) . "</pre>" );
		} else {
			$db = wfGetDB( DB_SLAVE );
			$db->query( "test" );
		}
	}
}


