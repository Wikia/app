<?php

/**
 * Installation script for the DidYouMean extension
 *
 * @addtogroup Extensions
 * @author Andrew Dunbar <hippytrail@gmail.com>
 * @copyright © 2007 Andrew Dunbar
 * @licence Copyright holder allows use of the code for any purpose
 */

# We're going to have to assume we're running from one of two places
## extensions/install.php (bad setup!)
## extensions/DidYouMean/install.php (the dir name doesn't even matter)
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
$sql = dirname( __FILE__ ) . '/didyoumean.sql';

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
$dba = $dbc->newFromParams( $wgDBserver, $wgDBadminuser, $wgDBadminpassword, $wgDBname, 1 );

# Check we're connected
if( !$dba->isOpen() ) {
	echo( "A connection to the database could not be established.\n\n" );
	die( 1 );
}

# Do nothing if the tables exist
if( $dba->tableExists( 'dympage' ) || $dba->tableExists( 'dymnorm' ) ) {
	echo( "The tables already exist. No action was taken.\n" );
} else {
	if( $wgDBtype == 'postgres' )
		$sql = dirname( __FILE__ ) . '/didyoumean.pg.sql';
	echo( "Sourcing: $sql\n" );
	$res = $dba->sourceFile( $sql );
	echo( "Result: $res\n" );
	if( $res ) {
		echo( "The tables have been set up correctly.\n" );

		require_once( 'DYMNorm.php' );

		$result = $dba->select(
			'page',
			array ( 'page_title', 'page_id' ),
			array (
				'page_namespace=0',
				'page_is_redirect=0'
			)
		);

		while( $row = $dba->fetchObject( $result ) ) {
			#echo "$row->page_title\n";

			$norm = wfDymNormalise($row->page_title);

			# *new* table using numeric columns where possible
			$theid = $dba->selectField( 'dymnorm', 'dn_normid', array( 'dn_normtitle' => $norm ) );
			if ($theid) {
				echo( "old: $row->page_title ->\t$norm = $theid\n" );
			} else {
				$normid = $dba->nextSequenceValue( 'dymnorm_dn_normid_seq' );
				$dba->insert( 'dymnorm', array( 'dn_normid' => $normid, 'dn_normtitle' => $norm ) );
				$theid = $dba->insertId();
				echo( "NEW: $row->page_title ->\t$norm = $theid\n" );
			}
			$dba->insert( 'dympage', array( 'dp_pageid' => $row->page_id, 'dp_normid' => $theid ) );
		}
		$dba->freeResult( $result );
	}
}
# Close the connection
$dba->close();
echo( "\n" );


