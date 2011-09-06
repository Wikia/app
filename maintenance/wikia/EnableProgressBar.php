<?php

/*
 * Simple script to enable Founder Progress Bar on wikis with < 250 edits
 *
 * USAGE: withcity --maintenance-script=EnableProgressBar.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php
 *
 * @date 2011-09-01
 * @author Owen Dais <owen at wikia-inc>
 */

#error_reporting( E_ERROR );

include( '../commandLine.inc' );

// list of allowed languages taken from Release plan
$allowedLanguages = array( 'en' );

//$oFlag = WikiFactory::getVarByName( 'wgEnableFounderProgressBarExt', $wgCityId );
if ( !WikiFactory::isPublic($wgCityId)) { 
	echo "$wgCityId: SKIPPING! Wiki is disabled. \n";
	exit;
}

if ( !in_array( $wgLanguageCode, $allowedLanguages ) ) {
	echo "$wgCityId: SKIPPING! Wiki's language ($wgLanguageCode) is not on the allowed languaes list.\n";
	exit;
}
$db = wfGetDB( DB_SLAVE );

$oRow = $db->selectRow(array('revision'), array('count(*) as count'), array());
if ( isset($oRow) && isset($oRow->count) && $oRow->count < 250 && $oRow->count > 5 ) {

	echo "$wgCityId enabled\n";
	WikiFactory::setVarByName( 'wgEnableFounderProgressBarExt', $wgCityId, 1);

	WikiFactory::clearCache( $wgCityId );
} else {
	echo "$wgCityId skipped, too many edits\n";
}

echo "$wgCityId: PROCESSING COMPLETED\n";
