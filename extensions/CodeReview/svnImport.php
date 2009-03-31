<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if( $IP === false )
	$IP = dirname( __FILE__ ). '/../..';
require "$IP/maintenance/commandLine.inc";

if( !isset( $args[0] ) ){
	echo "Usage: php svnImport.php <repo> [<start>]\n";
	die;
}

$repo = CodeRepository::newFromName( $args[0] );

if( !$repo ){
	echo "Invalid repo {$args[0]}\n";
	die;
}

$svn = SubversionAdaptor::newFromRepo( $repo->getPath() );
$lastStoredRev = $repo->getLastStoredRev();

$chunkSize = 400;

$startTime = microtime( true );
$revCount = 0;
$start = isset( $args[1] ) ? intval($args[1]) : $lastStoredRev + 1;
if( $start > ($lastStoredRev + 1) ){
	echo "Invalid starting point r{$start}\n";
	die;
}

echo "Syncing repo {$args[0]} from r$start to HEAD...\n";
while( true ) {
	$log = $svn->getLog( '', $start, $start + $chunkSize - 1 );
	if( empty($log) ) {
		# Repo seems to give a blank when max rev is invalid, which
		# stops new revisions from being added. Try to avoid this
		# by trying less at a time from the last point.
		if( $chunkSize <= 1 ) {
			break; // done!
		}
		$chunkSize = max( 1, floor($chunkSize/4) );
		continue;
	} else {
		$start += $chunkSize;
	}
	if( !is_array( $log ) ) {
		var_dump( $log );
		die( 'wtf' );
	}
	foreach( $log as $data ) {
		$revCount++;
		$delta = microtime( true ) - $startTime;
		$revSpeed = $revCount / $delta;

		$codeRev = CodeRevision::newFromSvn( $repo, $data );
		$codeRev->save();

		printf( "%d %s %s (%0.1f revs/sec)\n",
			$codeRev->mId,
			wfTimestamp( TS_DB, $codeRev->mTimestamp ),
			$codeRev->mAuthor,
			$revSpeed );
	}
	wfWaitForSlaves( 5 );
}

echo "Pre-caching the latest 50 diffs...\n";
$dbw = wfGetDB( DB_MASTER );
$res = $dbw->select( 'code_rev', 'cr_id', 
	array( 'cr_repo_id' => $repo->getId() ), 
	__METHOD__, 
	array( 'ORDER BY' => 'cr_id DESC', 'LIMIT' => 50 )
);
while( $row = $dbw->fetchObject( $res ) ) {
	$rev = $repo->getRevision( $row->cr_id );
	$diff = $repo->getDiff( $row->cr_id ); // trigger caching
	echo "Diff r{$row->cr_id} done\n";
}
echo "Done!\n";
