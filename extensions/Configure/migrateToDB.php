<?php

/**
 * Maintenance script that migrate configuration from files to database.
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

require_once( dirname( __FILE__ ) . "/migrateToDB.inc" );

$obj = new FilesToDB( $options );
$obj->run();
