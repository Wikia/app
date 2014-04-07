<?php
/**
 * @author: Christian, Inez
 *
 * Get familiar with "How_to_run_maintenance_script" article on internal to figure out how to run it.
 */
ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( "commandLine.inc" );

function fixBGImage( $id, $themeSettingsArray ) {
	$themeSettingsArray['background-image'] = '';

	WikiFactory::setVarByName( 'wgOasisThemeSettings', $id, $themeSettingsArray );
	WikiFactory::clearCache( $id );
}

function getBrokenThemeSettings( $id ) {
	$themeSettings = WikiFactory::getVarByName( 'wgOasisThemeSettings', $id );
	if ( !is_object($themeSettings) || empty($themeSettings->cv_value) ) {
		return null;
	}

	$themeSettingsArray = unserialize( $themeSettings->cv_value );
	$backgroundImage = $themeSettingsArray['background-image'];

	return ( getType( $backgroundImage ) !== 'string' || $backgroundImage === 'false' ) ? $themeSettingsArray : null;
}

$varid = WikiFactory::getVarIdByName( 'wgOasisThemeSettings', true );

$dbr = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);

$oRes = $dbr->select(
	'city_list',
	'city_id'
);

while ( $oRow = $dbr->fetchObject($oRes) ) {
	$themeSettingsArray = getBrokenThemeSettings( $oRow->city_id );
	if ( !is_null($themeSettingsArray) ) {
		// IMPORTANT! Uncomment line below if you really want it to work.
		//fixBGImage( $oRow->city_id, $themeSettingsArray );
		echo "Fixed Background Image for {$oRow->city_id}\n";
	} else {
		echo "Did not fix background image because it was okay\n";
	}
	echo "########################################\n";
}
$dbr->freeResult( $oRes );
