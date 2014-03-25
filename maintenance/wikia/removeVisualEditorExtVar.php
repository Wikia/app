<?php
/**
 * @author: Christian
 *
 * Get familiar with "How_to_run_maintenance_script" article on internal to figure out how to run it.
 */
ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( "commandLine.inc" );

function isVESet( $id ) {
	$out = WikiFactory::getVarByName( 'wgEnableVisualEditorExt', $id );
	if ( !is_object($out) || empty( $out->cv_value ) ) {
		return false;
	} else {
		return true;
	}
}

function removeVisualEditorExt( $id ) {
	WikiFactory::removeVarByName( 'wgEnableVisualEditorExt', $id );
	WikiFactory::clearCache( $id );
}

$varid = WikiFactory::getVarIdByName( 'wgEnableVisualEditorExt', true );

$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

$oRes = $dbr->select(
	'city_list',
	'city_id'
);

while ( $oRow = $dbr->fetchObject( $oRes ) ) {
	if ( isVESet( $oRow->city_id ) ) {
		// IMPORTANT! Uncomment line below if you really want it to work.
		// removeVisualEditorExt( $oRow->city_id );
		echo "Removed wgEnableVisualEditorExt for {$oRow->city_id}\n";
	} else {
		echo "Did not remove variable for {$oRow->city_id} because it was not set\n";
	}
	echo "########################################\n";
	exit();
}
$dbr->freeResult( $oRes );
