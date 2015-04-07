<?php

/**
 *  Script to find wikis which are missing certain tables.
 *
 *  The script does nothing directly to fix databases (it is read-only)
 *  In the examples we found so far, running update.php will fix this problem,
 *  so the script will generate output that can be run in the shell.
 *
 *  --cluster is the name of the cluster (a, b, c, d, e, f)
 *  --table is the name of the table to check for
 *  --skip X means don't check the first X wikis (due to memory problems)
 *  --limit X means return and print output after X wikis are scanned (due to memory problems)
 *  --details prints out the list of wikis that are affected
 *  --updates prints out a bunch of lines that look like:
 *
 *    SERVER_ID=1090870 php update.php --quick
 *
 *    Copy all those lines into a file and run "sh filename"
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$cluster = isset( $options[ "cluster" ] ) ? $options[ "cluster" ] : false;
$table = isset( $options[ "table" ] ) ? $options[ "table" ] : false;
$details = isset( $options[ "details" ] ) ? $options[ "details" ] : false;
$updates = isset( $options[ "updates" ] ) ? $options[ "updates" ] : false;
$skip = isset( $options[ "skip"] ) ? $options[ "skip" ] : false;
$limit = isset ( $options[ "limit"] ) ? $options[ "limit" ] : false;

if ($cluster == false) {
	echo "--cluster is required";
	exit();
}

if ($table == false) {
	echo "--table is required";
	exit();
}

$cluster_dbs = [
	"a" => "wikicities_c1",
	"b" => "wikicities_c2",
	"c" => "wikicities_c3",
	"d" => "wikicities_c4",
	"e" => "wikicities_c5",
	"f" => "wikicities_c6"
];

$missing = [];
$count = 0;

$db = wfGetDB(DB_MASTER, array(), $cluster_dbs[$cluster]);
$sth = $db->query("SHOW DATABASES");

// Connect to all databases and check for existence of $table
while ( $row = $db->fetchObject($sth) ) {
	if ($skip && ($count < $skip)) continue;
	if ($count % 1000 == 0) {
		echo "Processed " . (1000 + $count - $skip) . " wikis\n";
	}
	if ($limit && ($count - $skip) >= $limit) break;
	$count ++;

	$database = $row->Database;

	// don't talk to the wikicities cluster or internal mysql tables
	if ( strstr($database, 'wikicities_') !== false ) continue;
	if ( array_search($database, ['information_schema', 'mysql', 'tmp', 'logs', 'data']) !== false) continue;

	try {
		$wiki_db = wfGetDB(DB_SLAVE, [], $row->Database);
		if (! $wiki_db->tableExists($table)) {
			$wiki_id = WikiFactory::DBToId($row->Database);
			$missing[$wiki_id] = $row->Database;
		};
		$wiki_db->close();

	} catch (Exception $e) {
		continue;
	}

}

print("Found " . count($missing) . " databases missing $table\n");
if ($details) {
	print_r($missing);
}
if ($updates) {
	foreach ($missing as $id => $dbname) {
		echo "SERVER_ID=$id php update.php --quick\n";
	}
}