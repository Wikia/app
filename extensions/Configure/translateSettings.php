<?php

/**
 * Maintenance script that allows quick translation of settings in the extension.
 *
 * @file
 * @ingroup Extensions
 * @author Andrew Garrett
 * @license GPLv2 or higher
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false )
	$IP = dirname( __FILE__ ) . '/../..';

require_once( "$IP/maintenance/commandLine.inc" );

$settings = ConfigurationSettings::singleton( CONF_SETTINGS_CORE );
$settings = $settings->getSettings();

$settingNames = array();

asort( $settings );

foreach ( $settings as $group => $stuff ) {
	foreach ( $stuff as $key => $values ) {
		$theseSettings = array_keys( $values );
		$settingNames = array_unique( array_merge( $theseSettings, $settingNames ) );
	}
}

$translated = array();

require( 'default-setting-names.php' );

wfLoadExtensionMessages( 'ConfigureSettings' );

foreach ( $settingNames as $name ) {

	if ( !wfEmptyMsg( "configure-setting-$name", wfMsg( "configure-setting-$name" ) ) ) {
		print "\$$name already translated!\n";
		continue;
	}

	print "Please describe the following setting: \$$name\n";
	print trim( $defaultNames[$name] ) . "\n";

	$input = readconsole( '> ' );

	if ( trim( $input ) == '~' )
		break;

	if ( trim( $input ) == '' )
		$input = $defaultNames[$name];

	$translated[$name] = trim( $input );
}

foreach ( $translated as $key => $value ) {
	print "\t'configure-setting-$key' => \"$value\",\n";
}
