<?php
/**
 * Rebuild interwiki table using the file on Central Wikia
 * adapted from MW's rebuildInterwiki.php
 * @author Lucas 'TOR' Garczewski <tor@wikia.com>
 *
 * @addtogroup Maintenance
 */

$oldCwd = getcwd();

$optionsWithArgs = array( "o", "target" );

include_once( "../commandLine.inc" );
include_once( "updateCentralInterwiki.inc" );

if ( isset( $options['help'] ) || isset( $options['h']) ) {
die( "Produces an SQL file from Central\'s Interwiki_map article.\n
		  Usage: php updateCentralInterwiki.php [--o='file'|--target='id'|--global] [--verbose] [--force]

		  Prints to stdout by default.

		  --o        print to output file
		  --target   update interwikis for specified wiki (ID)
		  --global   do a global interwiki update for all wikis in city_list
		  --force    proceed, even if there were no changes to interwiki_map since last update
		  --verbose  print out information on each operation\n\n");
}

chdir( $oldCwd );

$verbose = (bool) (isset( $options['verbose'] ) || isset( $options['v'] ));
$global = (bool) (isset( $options ['global'] ) || isset( $options ['g'] ));
$force = (bool) (isset( $options ['force'] ) || isset( $options ['f'] ));

$sql = getRebuildInterwikiSQL();

if ( isset( $options['o'] ) ) {
	# Output to file specified with -o
	$file = fopen( $options['o'], "w" );
	fwrite( $file, $sql );
	fclose( $file );
} elseif ( $global || !empty( $options ['target'] ) ) {
	# Update interwiki tables in all wikias

	# Check if update is needed
	$lastupdate = WikiFactory::getVarValueByName('wgLastInterwikiUpdate', 177);
	$dbr = wfGetDB( DB_SLAVE );
	$dbr->selectDB('wikicities');
	$lastmod = $dbr->selectField('page', 'page_latest', "page_title = 'Interwiki_map' && page_namespace = 0");

	if ($lastupdate !== $lastmod || $force ) {

		if (!empty($options['target'])) {
			$res = $dbr->select('city_list', 'city_dbname', "city_id = ". $options['target']);
		} else {
			$res = $dbr->select('city_list', 'city_dbname');
		}
		$dbw =& wfGetDB( DB_MASTER );
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ($dbw->selectDB($row['city_dbname'])) {
				if ( $verbose )
					print "Updating database: ". $row['city_dbname']. "... ";
				$dbw->doQuery($sql);
			}
			if (isset( $verbose ))
				print "Done.\n";
		}

		$dbr->freeResult( $res );

		# Update $wgLastInterwikiUpdate
		if (empty($options['target'])) WikiFactory::SetVarByName('wgLastInterwikiUpdate', 177, $lastmod);

	} else {
		echo "No need to perform update. Aborting. Evoke this script with '--force' parameter to go ahead anyway.\n";
	}
} else {
	# Output to stdout
	print $sql;
}

?>
