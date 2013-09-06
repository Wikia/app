<?php
/**
 * This script connects to each cluster and loops through all the databases
 * - it skips anything matching wikicities*
 * - it skips databases with no revision table (basically non-wiki dbs)
 * It then tries to connect to the db using the normal MW db function
 * If it fails, that database is considered to be "missing".  Basically that
 *   means there is no entry in city_list for that database so it's orphaned
 * When finished, it prints out the list of missing dbs, and sorts the rest
 *   based on the most recent revision
 */

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
			// skip any non-wiki databases
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
