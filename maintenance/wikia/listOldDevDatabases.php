<?php
/**
 * This script connects to each cluster and loops through all the databases
 * - it skips anything matching wikicities* and *starter
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
$cluster_dbs = ['wikicities_c1', 'wikicities_c2'];  // Dev database only has these two for now

$list = array();
$missing = array();

foreach ($cluster_dbs as $cluster) {

	$db = wfGetDB(DB_MASTER, array(), $cluster);
	$sth = $db->query("SHOW DATABASES");

	while( $row = $db->fetchObject( $sth ) ) {

		print_r($row);
		// make sure we just skip all the wikicities and starter and help dbs no matter what for safety
		if (strpos($row->Database, "wikicities") !== false) continue;
		if (strpos($row->Database, "starter") !== false) continue;
		if (strpos($row->Database, "help") !== false) continue;
		if (strpos($row->Database, "information_schema") !== false) continue;

		try {
			$wiki_db = wfGetDB(DB_SLAVE, array(), $row->Database);
			// skip any non-wiki databases
			if (! $wiki_db->tableExists('revision')) continue;

			// get size of database
			$sql = "SELECT table_schema,
					Round(Sum(data_length + index_length) / 1024 / 1024, 1) as mb
					FROM information_schema.tables WHERE table_schema = '$row->Database'";

			$result = $wiki_db->query($sql);
			$size = $result->fetchObject();
			$list[$row->Database]['mb'] = $size->mb;

		} catch (Exception $e) {
			// This database does not exist in wikicities
			$missing[$row->Database] = $cluster;
			continue;
		}

		$last_ts = $wiki_db->selectField('revision', 'max(rev_timestamp)');
		$list[$row->Database]['ts'] = $last_ts;

	}

}


echo "Missing Databases (usually from being moved to different cluster):\n";
print_r($missing);

echo "Databases by Size:\n";
uasort($list, function($a, $b) { return $a['mb'] < $b['mb']; } );
print_r($list);
