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

include_once( "../commandLine.inc" );
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

$sql = getRebuildInterwikiSQL();

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

	$dbr = wfGetDB( DB_SLAVE, array(), 'wikicities');
	$lastmod = $dbr->selectField('page', 'page_latest', "page_title = 'Interwiki_map' && page_namespace = 0");

	# Check if update is needed
	$lastupdate = $wgLastInterwikiUpdate;
	if ( $lastupdate !== $lastmod || $force ) {
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
