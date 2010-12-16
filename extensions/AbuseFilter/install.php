<?php
/**
 * Makes the required changes for the AbuseFilter extension
 */

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );

$sqlfile = '/abusefilter.tables.sql';
if ( $wgDBtype == 'postgres' )
	 $sqlfile = '/abusefilter.tables.pg.sql';

dbsource( dirname( __FILE__ ) . $sqlfile );

// Create the Abuse Filter user.
wfLoadExtensionMessages( 'AbuseFilter' );
$user = User::newFromName( wfMsgForContent( 'abusefilter-blocker' ) );

if ( !$user->getId() ) {
	$user->addToDatabase();
	$user->saveSettings();
	# Increment site_stats.ss_users
	$ssu = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
	$ssu->doUpdate();
} else {
	// Sorry dude, we need this account.
	$user->setPassword( null );
	$user->setEmail( null );
	$user->saveSettings();
}

# Promote user so it doesn't look too crazy.
$user->addGroup( 'sysop' );
