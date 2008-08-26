<?php

define('MEDIAWIKI', true );

require_once("../../../StartProfiler.php");
require_once("../../../includes/Defines.php");
require_once("../../../LocalSettings.php");
require_once("Setup.php");
require_once("Copy.php");

function doCopy($dmid_dirty, $dc1_dirty, $dc2_dirty) {
	$dmid=mysql_real_escape_string($dmid_dirty);
	$dc1=mysql_real_escape_string($dc1_dirty);
	$dc2=mysql_real_escape_string($dc2_dirty);

	CopyTools::newCopyTransaction($dc1, $dc2);

	$dmc=new DefinedMeaningCopier($dmid, $dc1, $dc2);
	$dmc->dup(); 

	return true; # seems everything went ok.

}

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

	$sequence=array();
	$sequence[]=array('5249216', 'sp', 'uw');
	$sequence[]=array('5499828', 'sp', 'uw');
	$sequence[]=array('6247771', 'sp', 'uw');
	$sequence[]=array('7229499', 'sp', 'uw');

	
	$sequence[]=array('68242', 'umls', 'uw');
	$sequence[]=array('69856', 'umls', 'uw');
	$sequence[]=array('69931', 'umls', 'uw');
	$sequence[]=array('71663', 'umls', 'uw');
	$sequence[]=array('71902', 'umls', 'uw');
	
	echo "Connect ... \n";
	connect();

	#WARNING: Do this only once! (I still need to write a small script to call this)
	echo "doing bootstraps\n";

	mysql_query("START TRANSACTION");
	CopyTools::map_bootstraps("uw",array("uw", "sp"));
	
	echo "now copying\n";
	
	foreach ($sequence as $test) {
		$dmid=$test[0];
		$dc1=$test[1];
		$dc2=$test[2];
		echo "==== $dmid:   $dc1 -> $dc2  \n";
		doCopy($dmid,$dc1, $dc2);
		echo "\n";
	}
	mysql_query("ROLLBACK");
	#mysql_query("COMMIT");
}


main();

?>
