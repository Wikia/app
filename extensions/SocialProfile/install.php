<?php

/**
 * Installation script for the extension SocialProfile. MySQL only.
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @author Siebrand Mazeland
 * @copyright © 2006 Rob Church
 * @copyright © 2008 Siebrand Mazeland
 * @licence Copyright holder allows use of the code for any purpose
 */

# We're going to have to assume we are running from
# extensions/SocialProfile/install.php (the dir name doesn't even matter)
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

# Set up some paths
$dir = dirname(__FILE__) . '/';

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
$dba = new $dbclass ( $wgDBserver, $wgDBadminuser, $wgDBadminpassword, $wgDBname, 1 );

# Check we're connected
if( !$dba->isOpen() ) {
	echo( "A connection to the database could not be established.\n\n" );
	die( 1 );
}

# Do nothing if the table exists
if( $dba->tableExists( 'user_board' ) ) {
	echo( "The table already exists. No action was taken.\n" );
} else {
	$sql = $dir . '/UserBoard/user_board.sql';
	if( $dba->sourceFile( $sql ) ) {
		echo( "The table 'user_board' has been set up correctly.\n" );
	}
}

# Do nothing if the table exists
if( $dba->tableExists( 'user_profile' ) ) {
	echo( "The table already exists. No action was taken.\n" );
} else {
	$sql = $dir . '/UserProfile/user_profile.sql';
	if( $dba->sourceFile( $sql ) ) {
		echo( "The table 'user_profileard' has been set up correctly.\n" );
	}
}

# Do nothing if the table exists
if( $dba->tableExists( 'user_stats' ) ) {
	echo( "The table already exists. No action was taken.\n" );
} else {
	$sql = $dir . '/UserStats/user_stats.sql';
	if( $dba->sourceFile( $sql ) ) {
		echo( "The table 'user_stats' has been set up correctly.\n" );
	}
}

# Do nothing if the table exists
if( $dba->tableExists( 'user_relationship' ) || $dba->tableExists( 'user_relationship_request' ) ) {
	echo( "'user_relationship', and/or 'user_relationship_request' already exist. No action was taken.\n" );
} else {
	$sql = $dir . '/UserRelationship/user_relationship.sql';
	if( $dba->sourceFile( $sql ) ) {
		echo( "The tables 'user_relationship', and 'user_relationship_request' have been set up correctly.\n" );
	}
}

# Close the connection
$dba->close();
echo( "\n" );
