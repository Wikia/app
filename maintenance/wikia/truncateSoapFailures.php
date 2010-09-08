<?php
/**
 * Purge the SOAPfailures from Special:Soapfailures on LyricWiki.
 *
 * This script is meant to be run approximately every 10 days.
 *
 * @author Sean Colombo
 */

$dir = dirname(__FILE__);
require_once($dir . "/../commandLine.inc");

$TABLE_NAME = "lw_soap_failures";
if (isset($options['help'])) {
	die( "This script will completely truncate the $TABLE_NAME table for LyricWiki.  It should be run every 10 days via cron to keep the table small enough that it can be used quickly.  It can be run any time needed (but it helps us to have a few days of data in there)." );
}

$dbw = wfGetDB(DB_MASTER, array(), 'lyricwiki');
$res = $dbw->query("TRUNCATE $TABLE_NAME");
if(!$res){
	print "ERROR WHILE TRYING TO TRUNCATE $TALBE_NAME!!!\n";
}
