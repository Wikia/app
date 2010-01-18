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

	$dbr = wfGetDB( DB_SLAVE );
	$dbr->selectDB('wikicities');
	$lastmod = $dbr->selectField('page', 'page_latest', "page_title = 'Interwiki_map' && page_namespace = 0");

		if (!empty($options['target'])) {
			$res = $dbr->select('city_list', array('city_id', 'city_dbname'), "city_id = ". $options['target']);
		} else {
			$res = $dbr->select('city_list', array('city_id', 'city_dbname'));
		}
		while ( $row = $dbr->fetchRow( $res ) ) {
	# Check if update is needed
	$lastupdate = WikiFactory::getVarValueByName('wgLastInterwikiUpdate', $row['city_id']);
	if ( $lastupdate !== $lastmod || $force ) {
			wfWaitForSlaves( 100 );
			$dbw = wfGetDB( DB_MASTER, array(), $row['city_dbname'] );
			if ( $dbw != false ) {
				if ( $verbose )
					print "Updating database: ". $row['city_dbname']. "...\n";
				$dbw->doQuery($sql);
			}
		# Update $wgLastInterwikiUpdate
		WikiFactory::SetVarByName('wgLastInterwikiUpdate', $row['city_id'], $lastmod);
			if (isset( $verbose ))
				print "Done.\n";
	}
		}

		$dbr->freeResult( $res );

} else {
	# Output to stdout
	print $sql;
}
