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
if ( $IP === false )
	$IP = dirname( __FILE__ ) . '/../..';

require_once( "$IP/maintenance/commandLine.inc" );

# Functions

/**
 * Print a help message and exit
 */
function printHelp() {
	echo "Script that find settings that aren't configurable by the extension.\n";
	echo "\n";
	echo "Usage:\n";
	echo "  php findSettings.php [--help|--ext|--from-doc [--alpha]]\n";
	echo "\n";
	echo "options:\n";
	echo "--help: display this screen\n";
	echo "--ext: search for extensions settings\n";
	echo "--from-doc: compare with settings from mediawiki.org instead settings\n";
	echo "            from this extension\n";
	echo "--alpha: get the alphabetical list of settings\n";
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
	if ( $sort ) asort( $arr );
	foreach ( $arr as $v ) echo "$msg: $v\n";
}

# Main part

if ( isset( $options['help'] ) )
	printHelp();

$coreSettings = ConfigurationSettings::singleton( CONF_SETTINGS_CORE );
if ( isset( $options['ext'] ) ) {
	$exts = ConfigurationSettings::singleton( CONF_SETTINGS_EXT )->getAllExtensionsObjects();
	$ignoreList = array(
		# Core
		'wgTitle', 'wgArticle', 'wgContLang', 'wgLang', 'wgOut', 'wgParser', 'wgMessageCache',
		# Extensions
		'wgCaptcha', 'wgConfirmEditIP',
		'wgCitationCache', 'wgCitationCounter', 'wgCitationRunning',
		'wgCSS',
		'wgErrorHandlerErrors', 'wgErrorHandlerOutputDone',
		'wgExtParserFunctions',
		'wgTitleBlacklist',
	);
	foreach ( $exts as $ext ) {
		if( !$ext->isInstalled() ) continue; // must exist
		$file = file_get_contents( $ext->getFile() );
		$name = $ext->getName();
		$m = array();
		preg_match_all( '/\$(wg[A-Za-z0-9]+)\s*\=/', $file, $m );
		$definedSettings = array_unique( $m[1] );
		$allSettings = array_keys( $ext->getSettings() );

		$remain = array_diff( $definedSettings, $allSettings );
		$obsolete = array_diff( $allSettings, $definedSettings );
		$missing = array();
		foreach ( $remain as $setting ) {
			if ( !$coreSettings->isSettingAvailable( $setting ) && !in_array( $setting, $ignoreList ) )
				$missing[] = $setting;
		}
		if ( count( $missing ) == 0 && count( $obsolete ) == 0 ) {
			# echo "Extension $name ok\n";
		} else {
			echo "Extension $name:\n";
			printArray( '  missing', $missing );
			printArray( '  obsolete', $obsolete );
		}
	}
} else {
	// Get our settings defs
	if ( isset( $options['from-doc'] ) ) {
		if ( isset( $options['alpha'] ) ) {
			$page = "Manual:Configuration_settings_(alphabetical)";
		} else {
			$page = "Manual:Configuration_settings";
		}
		$cont = Http::get( "http://www.mediawiki.org/w/index.php?title={$page}&action=raw" );
		$m = array();
		preg_match_all( '/\[\[[Mm]anual:\$(wg[A-Za-z0-9]+)\|/', $cont, $m );
		$allSettings = array_unique( $m[1] );
	} else {
		$allSettings = array_keys( $coreSettings->getAllSettings() );
	}

	// Now we'll need to open DefaultSettings.php
	$m = array();
	$defaultSettings = file_get_contents( "$IP/includes/DefaultSettings.php" );
	preg_match_all( '/\$(wg[A-Za-z0-9]+)\s*\=/', $defaultSettings, $m );
	$definedSettings = array_unique( $m[1] );

	$missing = array_diff( $definedSettings, $allSettings );
	$remain = array_diff( $allSettings, $definedSettings );
	$obsolete = array();
	foreach ( $remain as $setting ) {
		if ( $coreSettings->isSettingAvailable( $setting ) )
			$obsolete[] = $setting;
	}

	// let's show the results:
	printArray( 'missing', $missing );
	printArray( 'obsolete', $obsolete );

	if ( count( $missing ) == 0 && count( $obsolete ) == 0 )
		echo "Looks good!\n";
}
