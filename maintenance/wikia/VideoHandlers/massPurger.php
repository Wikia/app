<?php

ini_set( 'display_errors', 'stdout' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( '../../commandLine.inc' );


$dbw = wfGetDB( DB_SLAVE );

echo "Purging articles:";

$rows = $dbw->query( "SELECT page_id FROM page WHERE page_namespace = 0" );

while( $page = $dbw->fetchObject( $rows ) ) {
	global $wgTitle;
	$wgTitle = $oTitle = Title::newFromId( $page->page_id );
	if ( $oTitle instanceof Title && $oTitle->exists() && ($oArticle = new Article ( $oTitle )) instanceof Article ) {
		$oTitle->purgeSquid();
		/* @var $oArticle Article */
		$oArticle->doPurge();
		echo "+";
	} else {
		echo "-";
	}
}

$dbw->freeResult($rows);

echo "\nDone\n";


?>
