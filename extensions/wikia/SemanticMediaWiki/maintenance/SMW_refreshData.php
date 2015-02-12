<?php
/**
 * Recreates all the semantic data in the database, by cycling through all
 * the pages that might have semantic data, and calling functions that
 * re-save semantic data for each one.
 *
 * Note: if SMW is not installed in its standard path under ./extensions
 *       then the MW_INSTALL_PATH environment variable must be set.
 *       See README in the maintenance directory.
 *
 * Usage:
 * php SMW_refreshData.php [options...]
 *
 * -d <delay>   Wait for this many milliseconds after processing an article, useful for limiting server load.
 * -s <startid> Start refreshing at given article ID, useful for partial refreshing
 * -e <endid>   Stop refreshing at given article ID, useful for partial refreshing
 * -n <numids>  Stop refreshing after processing a given number of IDs, useful for partial refreshing
 * --startidfile <startidfile> Read <startid> from a file instead of the arguments and write the next id
 *              to the file when finished. Useful for continual partial refreshing from cron.
 * -b <backend> Execute the operation for the storage backend of the given name
 *              (default is to use the current backend)
 * -v           Be verbose about the progress.
 * -c           Will refresh only category pages (and other explicitly named namespaces)
 * -p           Will refresh only property pages (and other explicitly named namespaces)
 * -t           Will refresh only type pages (and other explicitly named namespaces)
 * --page=<pagelist> will refresh only the pages of the given names, with | used as a separator.
 *              Example: --page="Page 1|Page 2" refreshes Page 1 and Page 2
 *              Options -s, -e, -n, --startidfile, -c, -p, -t are ignored if --page is given.
 * -f           Fully delete all content instead of just refreshing relevant entries. This will also
 *              rebuild the whole storage structure. May leave the wiki temporarily incomplete.
 * --server=<server> The protocol and server name to as base URLs, e.g.
 *              http://en.wikipedia.org. This is sometimes necessary because
 *              server name detection may fail in command line scripts.
 *
 * @author Yaron Koren
 * @author Markus Krötzsch
 * @file
 * @ingroup SMWMaintenance
 */

$optionsWithArgs = array( 'd', 's', 'e', 'n', 'b', 'startidfile', 'server', 'page' ); // -d <delay>, -s <startid>, -e <endid>, -n <numids>, --startidfile <startidfile> -b <backend>

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../../../maintenance/commandLine.inc' );

global $smwgEnableUpdateJobs, $wgServer, $wgTitle;
$wgTitle = Title::newFromText( 'SMW_refreshData.php' );
$smwgEnableUpdateJobs = false; // do not fork additional update jobs while running this script

if ( isset( $options['server'] ) ) {
	$wgServer = $options['server'];
}

if ( array_key_exists( 'd', $options ) ) {
	$delay = intval( $options['d'] ) * 1000; // convert milliseconds to microseconds
} else {
	$delay = false;
}

if ( isset( $options['page'] ) ) {
	$pages = explode( '|', $options['page'] );
} else {
	$pages = false;
}

$writeToStartidfile = false;
if ( array_key_exists( 's', $options ) ) {
	$start = max( 1, intval( $options['s'] ) );
} elseif ( array_key_exists( 'startidfile', $options ) ) {
	if ( !is_writable( file_exists( $options['startidfile'] ) ? $options['startidfile'] : dirname( $options['startidfile'] ) ) ) {
		die("Cannot use a startidfile that we can't write to.\n");
	}
	$writeToStartidfile = true;
	if ( is_readable( $options['startidfile'] ) ) {
		$start = max( 1, intval( file_get_contents( $options['startidfile'] ) ) );
	} else {
		$start = 1;
	}
} else {
	$start = 1;
}

if ( array_key_exists( 'e', $options ) ) { // Note: this might reasonably be larger than the page count
	$end = intval( $options['e'] );
} elseif ( array_key_exists( 'n', $options ) ) {
	$end = $start + intval( $options['n'] );
} else {
	$end = false;
}

if ( array_key_exists( 'b', $options ) ) {
	global $smwgDefaultStore;
	$smwgDefaultStore = $options['b'];
	print "\nSelected storage $smwgDefaultStore for update!\n\n";
}

$verbose = array_key_exists( 'v', $options );

$filterarray = array();
if (  array_key_exists( 'c', $options ) ) {
	$filterarray[] = NS_CATEGORY;
}
if (  array_key_exists( 'p', $options ) ) {
	$filterarray[] = SMW_NS_PROPERTY;
}
if (  array_key_exists( 't', $options ) ) {
	$filterarray[] = SMW_NS_TYPE;
}
$filter = count( $filterarray ) > 0 ? $filterarray : false;

if (  array_key_exists( 'f', $options ) ) {
	print "\n  Deleting all stored data completely and rebuilding it again later!\n  Semantic data in the wiki might be incomplete for some time while this operation runs.\n\n  NOTE: It is usually necessary to run this script ONE MORE TIME after this operation,\n  since some properties' types are not stored yet in the first run.\n  The first run can normally use the parameter -p to refresh only properties.\n\n";
	if ( ( array_key_exists( 's', $options ) )  || ( array_key_exists( 'e', $options ) ) ) {
		print "  WARNING: -s or -e are used, so some pages will not be refreshed at all!\n    Data for those pages will only be available again when they have been\n    refreshed as well!\n\n";
	}

	print 'Abort with control-c in the next five seconds ...  ';
	wfCountDown( 6 );

	smwfGetStore()->drop( $verbose );
	wfRunHooks( 'smwDropTables' );
	print "\n";
	SMWStore::setupStore( $verbose );
	while ( ob_get_level() > 0 ) { // be sure to have some buffer, otherwise some PHPs complain
		ob_end_flush();
	}
	echo "\nAll storage structures have been deleted and recreated.\n\n";
}

$linkCache = LinkCache::singleton();
$num_files = 0;
if ( $pages == false ) {
	print "Refreshing all semantic data in the database!\n---\n" .
	" Some versions of PHP suffer from memory leaks in long-running scripts.\n" .
	" If your machine gets very slow after many pages (typically more than\n" .
	" 1000) were refreshed, please abort with CTRL-C and resume this script\n" .
	" at the last processed page id using the parameter -s (use -v to display\n" .
	" page ids during refresh). Continue this until all pages were refreshed.\n---\n";
	print "Processing all IDs from $start to " . ( $end ? "$end" : 'last ID' ) . " ...\n";

	$id = $start;
	while ( ( ( !$end ) || ( $id <= $end ) ) && ( $id > 0 ) ) {
		if ( $verbose ) {
			print "($num_files) Processing ID " . $id . " ...\n";
		}
		smwfGetStore()->refreshData( $id, 1, $filter, false );
		if ( $delay !== false ) {
			usleep( $delay );
		}
		$num_files++;
		if ( $num_files % 100 === 0 ) { // every 100 pages only
			$linkCache->clear(); // avoid memory leaks
		}
	}
	if ( $writeToStartidfile ) {
		file_put_contents( $options['startidfile'], "$id" );
	}
	print "$num_files IDs refreshed.\n";
} else {
	print "Refreshing specified pages!\n\n";

	foreach ( $pages as $page ) {
		if ( $verbose ) {
			print "($num_files) Processing page " . $page . " ...\n";
		}

		$title = Title::newFromText( $page );

		if ( !is_null( $title ) ) {
			// wikia note - not migrating call to new jobqueue, since this is run directly
			$updatejob = new SMWUpdateJob( $title );
			$updatejob->run();
		}

		$num_files++;
	}

	print "$num_files pages refreshed.\n";
}
