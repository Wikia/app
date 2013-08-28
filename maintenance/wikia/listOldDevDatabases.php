<?php

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

# loop through clusters
$wikicities_db = wfGetDB(DB_MASTER, array(), 'wikicities');
$cluster_dbs = ['wikicities_c1', 'wikicities_c2'];

$list = array();
$missing = array();

foreach ($cluster_dbs as $cluster) {

	$db = wfGetDB(DB_MASTER, array(), $cluster);
	$sth = $db->query("SHOW DATABASES");

	while( $row = $db->fetchObject( $sth ) ) {

		// make sure we just skip all the wikicities dbs no matter what for safety
		if (strpos($row->Database, "wikicities") !== false) continue;

		try {
			$wiki_db = wfGetDB(DB_SLAVE, array(), $row->Database);
			if (! $wiki_db->tableExists('revision')) continue;
		} catch (Exception $e) {
			// This database does not exist in wikicities
			$missing[] = $row->Database;
			continue;
		}

		$last_ts = $wiki_db->selectField('revision', 'max(rev_timestamp)');
		$list[$row->Database] = $last_ts;

	}

}


echo "Missing Databases:\n";
print_r($missing);

echo "Databases by Revision:\n";
arsort($list);
print_r($list);
