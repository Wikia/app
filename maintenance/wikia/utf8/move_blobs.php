<?php

/**
 * Script tests fetching revision texts from external clusters
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Władysław Bodzek
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );

$optionsWithArgs = array(
	'from',
	'to',
);


require_once( "commandLine.inc" );

function help() {
	echo "usage: move_blobs.php --from [from_cluster.from_db.from_table] --to [to_cluster,to_db,to_table]\n";
	die(1);
}

if ( empty( $options['from'] ) || empty( $options['to'] ) ) {
	help();
}

list( $srcCluster, $srcDb, $srcTable ) = explode('.',$options['from'],3);
list( $dstCluster, $dstDb, $dstTable ) = explode('.',$options['to'],3);

//$src = wfGetLBFactory()->getExternalLB( $srcCluster )->getConnection( DB_MASTER, null, $srcDb );
//$dst = wfGetLBFactory()->getExternalLB( $dstCluster )->getConnection( DB_MASTER, null, $dstDb );

$src = wfGetDB( DB_MASTER, null, $srcCluster );
$dst = wfGetDB( DB_MASTER, null, $dstCluster );


// -- config
$chunkSize = 1000;
$delete = !empty($options['delete']);
// -- config end

$lowestId = 0;
$highestId = 0;
$count = 0;
while (1) {
	$set = $src->select(
		"`$srcDb`.`$srcTable`",
		array( 'blob_id', 'blob_text' ),
		array(
			"blob_id > $lowestId"
		),
		__METHOD__,
		array(
			'ORDER BY' => 'blob_id',
			'LIMIT' => $chunkSize,
		)
	);

	$data = array();
	while ($row = $src->fetchRow($set)) {
		$data[] = array(
			'blob_id' => $row['blob_id'],
			'blob_text' => $row['blob_text'],
		);
		$highestId = $row['blob_id'];
	}

	if ( empty( $data ) ) {
		break;
	}

	$dst->insert(
		"`$dstDb`.`$dstTable`",
		$data
	);

	if ( $delete )
	$src->delete(
		"`$srcDb`.`$srcTable`",
		array(
			"blob_id > $lowestId",
			"blob_id <= $highestId",
		)
	);

	$count += count($data);
	$lowestId = $highestId;
	echo "* processed $count items so far, last id = $highestId\n";
}

echo "moved $count blobs\n";