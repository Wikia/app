<?php

require_once( dirname(__FILE__).'/../WikimediaCommandLine.inc' );

$lines = file( $args[0] );
if ( !$lines ) {
	echo "Unable to open file {$args[0]}\n";
	exit( 1 );
}

$lines = array_map( 'trim', $lines );
$opsByWiki = array();

foreach ( $lines as $line ) {
	if ( !preg_match( '/
		^
		(\w+): \s*
		renaming \s
		(\d+) \s
		\((\d+),\'(.*?)\'\)
		/x',
		$line, $m ) )
	{
		continue;
	}

	list( $whole, $wiki, $pageId, $ns, $dbk ) = $m;

	$opsByWiki[$wiki][] = array(
		'id' => $pageId,
		'ns' => $ns,
		'dbk' => $dbk );
}

foreach ( $opsByWiki as $wiki => $ops ) {
	$lb = wfGetLB( $wiki );
	$db = $lb->getConnection( DB_MASTER, array(), $wiki );

	foreach ( $ops as $op ) {
		$msg = "{$op['id']} -> {$op['ns']}:{$op['dbk']}";

		# Sanity check
		$row = $db->selectRow( 'page', array( 'page_namespace', 'page_title' ),
			array( 'page_id' => $op['id'] ), __METHOD__ );
		if ( !$row ) {
			echo "$wiki: missing: $msg\n";
			continue;
		}

		if ( !preg_match( '/^Broken\//', $row->page_title ) ) {
			echo "$wiki: conflict: $msg\n";
			continue;
		}

		$db->update( 'page',
			/* SET */ array(
				'page_namespace' => $op['ns'],
				'page_title' => $op['dbk'] ),
			/* WHERE */ array(
				'page_id' => $op['id'] ),
			__METHOD__ );
		echo "$wiki: updated: $msg\n";
	}
	$lb->reuseConnection( $db );
}


