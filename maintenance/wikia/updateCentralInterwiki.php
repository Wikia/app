<?php
/**
 * Rebuild interwiki table using the file on Central Wikia
 * adapted from MW's rebuildInterwiki.php
 * @author Lucas 'TOR' Garczewski <tor@wikia.com>
 *
 * @addtogroup Maintenance
 */

$oldCwd = getcwd();

$optionsWithArgs = array( "o" );

ini_set( "include_path", dirname(__FILE__)."/.." );
include_once( "commandLine.inc" );
include_once( "updateCentralInterwiki.inc" );

if ( isset( $options['help'] ) || isset( $options['h']) ) {
die( "Produces an SQL file from Central\'s Interwiki_map article.\n
		  Usage: php updateCentralInterwiki.php [--o='file'|--p] [--verbose] [--force]

		  Prints to stdout by default.

		  --o        print to output file
		  --p        print to stdout
		  --force    proceed, even if there were no changes to interwiki_map since last update
		  --verbose  print out information on each operation\n\n");
}

chdir( $oldCwd );

$verbose = (bool) (isset( $options['verbose'] ) || isset( $options['v'] ));
$force = (bool) (isset( $options ['force'] ) || isset( $options ['f'] ));

if ($verbose) echo "--force is " . ( $force ? "true" : "false" ) . "\n";

$key = "ciw_timestamp";
$ciw_timestamp = $wgMemc->get($key);
if ($force || empty($ciw_timestamp)) {
	$dbr = wfGetDB( DB_SLAVE, array(), 'wikicities');
	$ciw_timestamp = $dbr->selectField('page', 'page_latest', "page_title = 'Interwiki_map' && page_namespace = 8");
	$wgMemc->set($key, $ciw_timestamp, 3600);
	if ($verbose) echo "ciw_timestamp not from cache\n";
}
if ($verbose) echo "ciw_timestamp: {$ciw_timestamp}\n";

$key = "ciw_sql";
list($ciw_sql_timestamp, $sql) = $wgMemc->get($key);
if ($force || empty($ciw_sql_timestamp) || empty($sql) || $ciw_sql_timestamp < $ciw_timestamp) {
	$ciw_sql_timestamp = $ciw_timestamp;
	$sql = getRebuildInterwikiSQL();
	$wgMemc->set($key, array($ciw_sql_timestamp, $sql));
	if ($verbose) echo "ciw_sql not from cache\n";
}
if ($verbose) echo "ciw_sql_timestamp: {$ciw_sql_timestamp}\n";

if ( isset( $options['o'] ) ) {
	# Output to file specified with -o
	$file = fopen( $options['o'], "w" );
	fwrite( $file, $sql );
	fclose( $file );
} elseif ( isset( $options ['p'] ) ) {
	# Output to stdout
	print $sql;
} else {
	# Update interwiki tables in all wikias

	# Check if update is needed
	$lastupdate = $wgLastInterwikiUpdate;
	if ($verbose) echo "lastupdate: {$lastupdate}\n";
	$lastmod = $ciw_timestamp;
	if ($verbose) echo "lastmod: {$lastmod}\n";
	if ( $lastupdate !== $lastmod || $force ) {
		if ($verbose) echo "lastupdate != lastmod (or forced update)\n";
			wfWaitForSlaves( 100 );
			$dbw = wfGetDB( DB_MASTER );
			if ( $dbw != false ) {
				if ( $verbose )
					print "Updating database...\n";
				$dbw->doQuery($sql);
			}
		# Update $wgLastInterwikiUpdate
		WikiFactory::SetVarByName('wgLastInterwikiUpdate', $wgCityId, $lastmod);
			if (isset( $verbose ))
				print "Done.\n";
	}

}
