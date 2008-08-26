<?php

require_once("extensions/Wikidata/OmegaWiki/WikiDataAPI.php"); // for bootstrapCollection
require_once("extensions/Wikidata/OmegaWiki/Transaction.php");
require (dirname(__FILE__) . '/includes/WebStart.php');
global $wgUser;

function getDatasets(){
	$datasets = array();
	$dbr = &wfGetDB(DB_SLAVE);
	$result = $dbr->query( "select set_prefix from wikidata_sets" );
	while ($record = $dbr->fetchObject($result)) {
		array_push( $datasets, $record->set_prefix );
	}
	return $datasets;
}

function setUser( $userid ){
	global $wgUser;
	$wgUser->setId( $userid );
	$wgUser->loadFromId();
}

function setDefaultDC( $dc ){
	global $wgUser, $wdDefaultViewDataSet;

	$groups=$wgUser->getGroups();
	foreach($groups as $group) {
		$wdGroupDefaultView[$group] = $dc;
	}
	$wdDefaultViewDataSet = $dc;
}

function getUserId( $userName ){
	$dbr = &wfGetDB(DB_SLAVE);
	$result = $dbr->query( "select user_id from user where user_name = '$userName'" );
	if ( $row = $dbr->fetchObject( $result ) ){
		return $row->user_id;
	}
	else {
		return -1;
	}
}

$userId = getUserId( 'Root' );
if ( $userId == -1 ){
	echo "root user undefined\n";
	die;
}

setUser( $userId );
$datasets = getDatasets();

$dbr = &wfGetDB(DB_SLAVE);
foreach( $datasets as $dataset ){
	foreach( $datasets as $otherdataset ){
		if ( $dataset != $otherdataset ){
			echo "mapping between $otherdataset and $dataset\n";
			setDefaultDC( $otherdataset );
			startNewTransaction($userId, wfGetIP(), 'Add collection ', $dataset);
			bootstrapCollection($dataset,'85','MAPP');
		}
	}
}
?>