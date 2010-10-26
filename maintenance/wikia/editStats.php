<?php
 
require_once( dirname(__FILE__).'/../commandLine.inc' );
echo( "Refresh Wikia Edits Statistics\n\n" );

if ( empty($options['date']) ) {
	$options['date'] = date('Y-m-d');	
}

if ( isset( $options['help'] ) ) {
	showHelp();
	exit();
}

require_once( dirname(__FILE__).'/../../extensions/wikia/TextRegex/TextRegex.php' );
wfEditStats($options);

function showHelp() {
	echo( "Re-initialise the edit statistics tables.\n\n" );
	echo( " --date : generate stats for YYYY-MM-DD day\n" );
	echo( "Usage: php initStats.php \n\n" );
}

function wfEditStats($options = array()) {
	global $wgExternalDatawareDB, $wgDBname;

	$m = array();
	$count_edits = $count_content_edits = 0;
	$count_editors = $count_content_editors = 0;
	$count_anons = $count_content_anons = 0;
	
	$dbr = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB );

	###################
	wfOut( "\nCounting total edits..." );
	$conditions = array( "pe_date" => $options['date'] );
	
	$oRow = $dbr->selectRow(
		array( "page_edits" ),
		array( "sum(pe_all_count) as all_count" ),
		$conditions,
		__METHOD__
	);
	if ( $oRow ) $count_edits = intval($oRow->all_count);
	
	###################
	wfOut( "\nCounting total content namespaces edits..." );
	$conditions['pe_is_content'] = 1;
	$oRow = $dbr->selectRow(
		array( "page_edits" ),
		array( "sum(pe_all_count) as all_count" ),
		$conditions,
		__METHOD__
	);
	if ( $oRow ) $count_content_edits = intval($oRow->all_count);

	###################
	wfOut( "\nCounting total editors..." );
	$conditions = array( "pc_date" => $options['date'] );
	$oRow = $dbr->selectRow(
		array( "page_editors" ),
		array( "sum(pc_all_count) as all_count" ),
		$conditions,
		__METHOD__
	);
	if ( $oRow ) $count_editors = intval($oRow->all_count);

	###################
	wfOut( "\nCounting total content editors..." );
	$conditions['pc_is_content'] = 1;
	$oRow = $dbr->selectRow(
		array( "page_editors" ),
		array( "sum(pc_all_count) as all_count" ),
		$conditions,
		__METHOD__
	);
	if ( $oRow ) $count_content_editors = intval($oRow->all_count);

	###################
	wfOut( "\nCounting total anons..." );
	$conditions = array( 
		"pc_date" => $options['date'],
		"pc_user_id" => 0
	);
	$oRow = $dbr->selectRow(
		array( "page_editors" ),
		array( "sum(pc_all_count) as all_count" ),
		$conditions,
		__METHOD__
	);
	if ( $oRow ) $count_anons = intval($oRow->all_count);

	###################
	wfOut( "\nCounting total content editors..." );
	$conditions['pc_is_content'] = 1;
	$oRow = $dbr->selectRow(
		array( "page_editors" ),
		array( "sum(pc_all_count) as all_count" ),
		$conditions,
		__METHOD__
	);
	if ( $oRow ) $count_content_anons = intval($oRow->all_count);

	###################
	wfOut( "\nUpdating page statistics..." );
	$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

	$values = array( 
		'pe_edits' => $count_edits,
		'pe_content_edits' => $count_content_edits,
		'pe_editors' => $count_editors,
		'pe_content_editors' => $count_content_editors,
		'pe_anon_editors' => $count_anons,
		'pe_anon_content_editors' => $count_content_anons
	);
	$conds = array( 'pe_date' => $options['date'] );
	$dbw->delete( 'page_edits_month', $conds, __METHOD__ );
	$dbw->insert( 'page_edits_month', array_merge( $values, $conds ), __METHOD__ );

	###################
	# make other stats
	wfOut( "\nRegenerate editors/pages statistics to memc...(for home page stats) " );
	for ( $i = 1; $i <= 7; $i++ ) {
		wfOut( "\nTop 10 most edited pages (per editors) in last $i days  ... " );
		WikiaGlobalStats::getPagesEditors($i, 10, true, true, false, true);
		WikiaGlobalStats::getPagesEditors($i, 10, true, false, false, true);
		wfOut( "\nTop 5 most edited pages (per editors) in last $i days ... " );
		WikiaGlobalStats::getPagesEditors($i, 5, true, true, false, true);
		WikiaGlobalStats::getPagesEditors($i, 5, true, false, false, true);
	}

	for ( $i = 1; $i <= 7; $i++ ) {
		wfOut( "\nTop 10 most edited pages in last $i days  ... " );
		WikiaGlobalStats::getEditedArticles($i, 10, true, true);
		wfOut( "\nTop 5 most edited pages in last $i days ... " );
		WikiaGlobalStats::getEditedArticles($i, 5, true, true);
		wfOut( "\Number of words in last $i days ... " );
		WikiaGlobalStats::countWordsInLastDays($i, 1);
	}

	#$memkey = wfMemcKey( "WS:getPagesEditors", 3, 10, 1, 0, 0 );
	#echo "memkey = $memkey \n";
	#echo print_r( $wgMemc->get( $memkey ), true );

	wfOut( "\ndone.\n" );
}

wfOut( "\nFinished.\n" );

