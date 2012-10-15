<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/commandLine.inc" );

echo "Usage: php deleteBadTags.php [commit]\n";

echo "Deleting empty tags...\n";

$dbw = wfGetDB( DB_MASTER );
$dbw->begin();
$dbw->delete( 'code_tags', array('ct_tag' => ''), __METHOD__ );
$count = $dbw->affectedRows();
if( isset($args[0]) && $args[0] == 'commit' ) {
	$dbw->commit();
	echo "$count bad tags deleted. Done!\n";
} else {
	$dbw->rollback();
	echo "$count bad tags. Not commited!\n";
}
