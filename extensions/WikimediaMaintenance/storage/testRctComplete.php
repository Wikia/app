<?php
require_once( dirname(__FILE__).'/../WikimediaCommandLine.inc' );

$bad = 0;
$good = 0;
foreach ( $wgLocalDatabases as $wiki ) {
	$lb = wfGetLB( $wiki );
	$db = $lb->getConnection( DB_SLAVE, array(), $wiki );
	if ( $db->tableExists( 'blob_tracking' ) ) {
		$notDone = $db->selectField( 'blob_tracking', '1',
			array( 'bt_moved' => 0 ) );
		if ( $notDone ) {
			$bad++;
			echo "$wiki\n";
		} else {
			$good++;
		}
	}
	$lb->reuseConnection( $db );
}
echo "$bad wiki(s) incomplete\n";
echo "$good wiki(s) complete\n";
