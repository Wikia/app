<?php

/**
 * Maintenance script that helps to do maintenance with configuration files.
 *
 * @file
 * @ingroup Extensions
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 */

$optionsWithArgs = array( 'wiki', 'version', 'file' );

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false )
	$IP = dirname( __FILE__ ) . '/../..';

require_once( "$IP/maintenance/commandLine.inc" );

require_once( dirname( __FILE__ ) . '/writePHP.inc' );

$obj = new ConfigurationWriter( $options );
$obj->run();
