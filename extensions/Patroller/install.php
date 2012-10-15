<?php

/**
 * Installation script for the Patroller extension
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence Copyright holder allows use of the code for any purpose
 */

# We're going to have to assume we're running from one of two places
## extensions/install.php (bad setup!)
## extensions/Patroller/install.php (the dir name doesn't even matter)
$maint = dirname( dirname( __FILE__ ) ) . '/maintenance';
if( is_file( $maint . '/commandLine.inc' ) ) {
	require_once( $maint . '/commandLine.inc' );
} else {
	$maint = dirname( dirname( dirname( __FILE__ ) ) ) . '/maintenance';
	if( is_file( $maint . '/commandLine.inc' ) ) {
		require_once( $maint . '/commandLine.inc' );
	} else {
		# We can't find it, give up
		echo( "The installation script was unable to find the maintenance directories.\n\n" );
		die( 1 );
	}
}

$dbw = wfGetDB( DB_MASTER );

# Do nothing if the table exists
if( !$dbw->tableExists( 'patrollers' ) ) {
	if( $dbw->sourceFile( dirname( __FILE__ ) . '/patroller.sql' ) ) {
		echo( "The table has been set up correctly.\n" );
	}
} else {
	echo( "The table already exists. No action was taken.\n" );
}

echo( "\n" );
