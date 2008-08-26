<?php

define('MEDIAWIKI', true );

require_once("../../../StartProfiler.php");
require_once("../../../includes/Defines.php");
require_once("../../../LocalSettings.php");
require_once("Setup.php");
require_once("Copy.php");

/** connect to database. */
function connect() {

	global $wgDBserver, $wgDBuser, $wgDBpassword, $wgDBname;

	$db1=$wgDBserver;  # hostname
	$db2=$wgDBuser;  # user
	$db3=$wgDBpassword;  # pass
	$db4=$wgDBname;  # db-name

	$connection=MySQL_connect($db1,$db2,$db3);
	if (!$connection)die("Cannot connect to SQL server. Try again later.");
	MySQL_select_db($db4)or die("Cannot open database");
	mysql_query("SET NAMES 'utf8'");
}

/** start a transactions,
 * perform copy in transaction
 * then roll it back, so we can use the same
 * db over again.
 */
function main() {
	echo "Connect ... \n";
	connect();

	mysql_query("START TRANSACTION");
	echo "doing bootstraps\n";
	CopyTools::map_bootstraps("uw",array("uw", "sp"));
	mysql_query("COMMIT");
	echo "done.\n";
}


main();

?>
