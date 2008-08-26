<?php

/* Read a .sql file and apply it to tables with the defined prefix. 

NOTE: Since LocalSettings.php loads App.php, which depends on a whole lot of 
Wikidata crud, in some circumstances (when your code refers to tables that
no longer exist) it may be wise to comment out the require_once line
in LocalSettings.php which loads App.php before running this script.

*/

define('MEDIAWIKI', true );
ob_end_flush();

$wgUseMasterForMaintenance = true;

$sep = PATH_SEPARATOR;

$IP = realpath( dirname( __FILE__ ) .  "/../../../../" );
$currentdir = dirname( __FILE__ );
chdir( $IP );

ini_set( 'include_path', ".$sep$IP$sep$IP/extensions/Wikidata/OmegaWiki$sep$IP/includes$sep$IP/languages$sep$IP/maintenance" );

require_once( "Defines.php");
require_once( "ProfilerStub.php");
require_once( "LocalSettings.php");
require_once( "Setup.php");
require_once( "StartProfiler.php" );
require_once( "Exception.php");
require_once( "GlobalFunctions.php");
require_once( "Database.php");
include_once( "AdminSettings.php");

global
	$wgCommandLineMode, $wgUser, $numberOfBytes;

function ReadSQLFile( $database, $pattern, $prefix, $filename ){
	$fp = fopen( $filename, 'r' );
	if ( false === $fp ) {
		return "Could not open \"{$filename}\".\n";
	}

	$cmd = "";
	$done = false;

	while ( ! feof( $fp ) ) {
		$line = trim( fgets( $fp, 1024 ) );
		$sl = strlen( $line ) - 1;

		if ( $sl < 0 ) { continue; }
		if ( '-' == $line{0} && '-' == $line{1} ) { continue; }

		if ( ';' == $line{$sl} && ($sl < 2 || ';' != $line{$sl - 1})) {
			$done = true;
			$line = substr( $line, 0, $sl );
		}

		if ( '' != $cmd ) { $cmd .= ' '; }
		$cmd .= "$line\n";

		if ( $done ) {
			$cmd = str_replace(';;', ";", $cmd);
			$cmd = trim( str_replace( $pattern, $prefix, $cmd ) );
			$res = $database->query( $cmd );

			if ( false === $res ) {
				return "Query \"{$cmd}\" failed with error code \".\n";
			}

			$cmd = '';
			$done = false;
		}
	}
	fclose( $fp );
	return true;
}

function getUserId( $userName ){
	$dbr = &wfGetDB(DB_SLAVE);
	$result = $dbr->query( "select user_id from user where user_name = '$userName'" );
	if ( $row = $dbr->fetchObject( $result ) ){
		return $row->user_id;
	}
	else {
		return -1;
	}
}

function setUser( $userid ){
	global $wgUser;
	$wgUser->setId( $userid );
	$wgUser->loadFromId();
}

function setDefaultDC( $dc ){
	global $wgUser, $wdDefaultViewDataSet;

	$groups=$wgUser->getGroups();
	foreach($groups as $group) {
		$wdGroupDefaultView[$group] = $dc;
	}
	$wdDefaultViewDataSet = $dc;
}

	
$dbclass  = 'Database' . ucfirst( $wgDBtype ) ;
$database = $wgDBname;
$user     = $wgDBadminuser;
$password = $wgDBadminpassword;
$server   = $wgDBserver;

# Parse arguments
for( $arg = reset( $argv ); $arg !== false; $arg = next( $argv ) ) {
	if ( substr( $arg, 0, 8 ) == '-dataset' ) {
		$prefix = next( $argv );
		$wdPrefix = $prefix . "_";
	}
	else if ( substr( $arg, 0, 9 ) == '-template' ) {
		$wdTemplate = next( $argv );
	}
	else if ( substr( $arg, 0, 7 ) == '-server' ) {
		$server = next( $argv );
	}
	else if ( substr( $arg, 0, 9 ) == '-database' ) {
		$database = next( $argv );
	}
	else if ( substr( $arg, 0, 5 ) == '-user' ) {
		$user = next( $argv );
	}
	else if ( substr( $arg, 0, 9 ) == '-password' ) {
		$password = next( $argv );
	} else {
		$args[] = $arg;
	}
}

if ( !isset( $wdTemplate ) ){
	echo( "SQL template should be provided!\n");
	echo( "usage: ReadPatch.php -dataset <prefix> -template <sql template> [-server <server> -database <database> -user <username> -password <password>]\n");
	exit();
}

if ( !isset( $wdPrefix ) ){
	echo( "database prefix should be provided!\n");
	echo( "usage: ReadPatch.php -dataset <prefix> -template <sql template> [-server <server> -database <database> -user <username> -password <password>]\n");
	exit();
}

# Do a pre-emptive check to ensure we've got credentials supplied
# We can't, at this stage, check them, but we can detect their absence,
# which seems to cause most of the problems people whinge about
if( !isset( $user ) || !isset( $password ) ) {
	echo( "No superuser credentials could be found. Please provide the details\n" );
	echo( "of a user with appropriate permissions to update the database. See\n" );
	echo( "AdminSettings.sample for more details.\n\n" );
	exit();
}
# Attempt to connect to the database as a privileged user
# This will vomit up an error if there are permissions problems
$wdDatabase = new $dbclass( $server, $user, $password, $database, 1 );

if( !$wdDatabase->isOpen() ) {
	# Appears to have failed
	echo( "A connection to the database could not be established. Check the\n" );
	echo( "values of \$wgDBadminuser and \$wgDBadminpassword.\n" );
	exit();
}



ReadSQLFile( $wdDatabase, "/*\$wdPrefix*/", $wdPrefix, $currentdir . DIRECTORY_SEPARATOR . $wdTemplate );

$wdDatabase->close();


?>