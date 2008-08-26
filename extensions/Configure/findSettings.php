<?php

/**
 * Maintenance script that find settings that aren't configurable by the
 * extension.
 * Based on findhooks.php
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if( $IP === false )
	$IP = dirname( __FILE__ ). '/../..';

require_once( "$IP/maintenance/commandLine.inc" );

# Functions

/**
 * Print a help message and exit
 */
function printHelp(){
	echo "Script that find settings that aren't configurable by the extension.\n";
	echo "\n";
	echo "Usage:\n";
	echo "  php findSettings.php [--help|--from-doc]\n";
	echo "\n";
	echo "options:\n";
	echo "--help: display this screen\n";
	echo "--from-doc: compare with settings from mediawiki.org instead settings\n";
	echo "            from this extension\n";
	echo "\n";
	exit;
}

/**
 * Nicely output the array
 * @param $msg A message to show before the value
 * @param $arr An array
 * @param $sort Boolean : wheter to sort the array (Default: true)
 */
function printArray( $msg, $arr, $sort = true ) {
	if($sort) asort($arr); 
	foreach($arr as $v) echo "$msg: $v\n";
}

# Main part

if( isset( $options['help'] ) )
	printHelp();

// Get our settings defs
if( isset( $options['from-doc'] ) ){
	$cont = Http::get( 'http://www.mediawiki.org/w/index.php?title=Manual:Configuration_settings&action=raw' );
	$m = array();
	preg_match_all( '/\[\[[Mm]anual:\$(wg[A-Za-z0-9]+)\|/', $cont, $m );
	$allSettings = array_unique( $m[1] );
} else {
	$allSettings = array_keys( ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->getAllSettings() );
}

// Now we'll need to open DefaultSettings.php
$m = array();
$defaultSettings = file_get_contents( "$IP/includes/DefaultSettings.php" );
preg_match_all( '/\$(wg[A-Za-z0-9]+)\s*\=/', $defaultSettings, $m );
$definedSettings = array_unique( $m[1] );

$missing = array_diff( $definedSettings, $allSettings );
$remain = array_diff( $allSettings, $definedSettings );
$obsolete = array();
foreach( $remain as $setting ){
	if( ConfigurationSettings::singleton( CONF_SETTINGS_CORE )->isSettingAvailable( $setting ) )
		$obsolete[] = $setting;
}

// let's show the results:
printArray('missing', $missing );
printArray('obsolete', $obsolete );
 
if( count( $missing ) == 0 && count( $obsolete ) == 0 ) 
	echo "Looks good!\n";