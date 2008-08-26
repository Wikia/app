<?php

/**
 * Installation script for the bad image list extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence Copyright holder allows use of the code for any purpose
 */

# We're going to have to assume we're running from one of two places
## extensions/install.php (bad setup!)
## extensions/BadImage/install.php (the dir name doesn't even matter)
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

# Set up some other paths
$sql = dirname( __FILE__ ) . '/badimage.sql';

# Whine if we don't have appropriate credentials to hand
if( !isset( $wgDBadminuser ) || !isset( $wgDBadminpassword ) ) {
	echo( "No superuser credentials could be found. Please provide the details\n" );
	echo( "of a user with appropriate permissions to update the database. See\n" );
	echo( "AdminSettings.sample for more details.\n\n" );
	die( 1 );
}

# Get a connection
$dbclass = $wgDBtype == 'MySql'
			? 'Database'
			: 'Database' . ucfirst( strtolower( $wgDBtype ) );
$dbc = new $dbclass;
$dba =& $dbc->newFromParams( $wgDBserver, $wgDBadminuser, $wgDBadminpassword, $wgDBname, 1 );

# Check we're connected
if( !$dba->isOpen() ) {
	echo( "A connection to the database could not be established.\n\n" );
	die( 1 );
}

# Do nothing if the table exists
if( $dba->tableExists( 'bad_images' ) ) {
	echo( "The table already exists. No action was taken.\n" );
} else {
	if ($wgDBtype == 'postgres')
		$sql = dirname( __FILE__ ) . '/badimage.pg.sql';
	if( $dba->sourceFile( $sql ) ) {
		echo( "The table has been set up correctly.\n" );
	}
}

# Close the connection
$dba->close();
echo( "\n" );

