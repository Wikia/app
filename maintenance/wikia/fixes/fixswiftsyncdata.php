<?php

ini_set( "include_path", dirname(__FILE__)."/../../" );
require( "commandLine.inc" );

if (isset($options['help'])) {
	die( "fix images to sync in swift_sync table" );
}

$help = isset($options['help']);
$dry = isset($options['dry']) ? $options['dry'] : "";
$limit = isset( $options['limit'] ) ? $options['limit'] : "";

$method = 'fixAllSwiftSyncData';

$image_upload_paths = array();
function getCityIdByImagePath( $image_path ) {
	global $image_upload_paths, $method, $wgExternalSharedDB;
	
	if ( !empty( $image_upload_paths[ $image_path ] ) ) {
		$city_id = $image_upload_paths[ $image_path ];
		print "found city_id: $result, ";
		return $city_id;
	}
	
	$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

	$data = $dbr->selectRow(
		'city_variables',
		[ 'cv_city_id' ],
		[
			'cv_variable_id' => 16,
			'cv_value' => $image_path
		],
		$method
	);

	$result = 0;
	if ( !empty( $data ) ) {
		$result = $data->cv_city_id;
		$image_upload_paths[ $image_path ] = $result;
		print "found city_id: $result, ";
	}
	
	return $result;
}

function moveRecordToActiveQueue( $row, $dry ) {
	global $wgSpecialsDB;
	$dbw = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );
	# move record to image_sync table

	if ( !$dry ) {
		$dbw->insert( '`swift_sync`.`image_sync`', 
			[ 
				'id'			=> $row->id,
				'city_id'		=> $row->city_id,
				'img_action'	=> $row->img_action,
				'img_src'		=> $row->img_src,
				'img_dest'		=> $row->img_dest,
				'img_added'		=> $row->img_added,
				'img_sync'		=> $row->img_sync
			],
			__METHOD__,
			'IGNORE' 
		);
		
		if ( $dbw->affectedRows() ) {
			print " added \n"; 
					
			# remove record from image_sync_done table;
			$dbw->delete( '`swift_sync`.`image_sync_done`', array( 'id' => $row->id ), 	__METHOD__ );
			return true;
		} else {
			print " cannot be added \n"; 
			return false;
		}
	} else {
		print " insert record " . $row->id . " to image_sync table and remove from image_sync_done table \n";
	}
}

function fixAllSwiftSyncData( $dry, $limit ) {
	global $wgSpecialsDB, $method;

	$dbr = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );
	$res = $dbr->select(
		[ '`swift_sync`.`image_sync_done`' ],
		[ 'id, city_id, img_action, img_src, img_dest, img_added, img_sync, img_error' ],
		[
			'city_id' => 0,
		],
		$method,
		[ 'ORDER BY' => 'id', 'LIMIT' => $limit ]
	);

	$rows = array();
	while( $row = $dbr->fetchObject($res) ) {
		$rows[] = $row;
	}
	$dbr->freeResult( $res );

	print sprintf("Found %0d rows to fix \n", count( $rows ) );
	
	foreach ( $rows as $row ) {
		print "Parsing " . $row->id . ", ";
		$image_path_dir = null;
		if ( preg_match( '/swift\-backend\/(.*)\/images/', $row->img_dest, $data ) ) {
			$image_path_dir = $data[1];
		}

		if ( empty( $image_path_dir ) ) {
			print " cannot find image_path_dir \n";
			continue;
		}
		
		$image_path = sprintf( "http://images.wikia.com/%s/images", $image_path_dir );
		$serialized_image_path = serialize( $image_path );
		
		print "path: " . $serialized_image_path . ", ";
		
		$row->city_id = getCityIdByImagePath( $serialized_image_path );
		
		if ( $row->city_id > 0 ) {
			moveRecordToActiveQueue( $row, $dry );
		} else {
			print " cannot find city_id \n";
		}
	}
}


if ( $help ) {
	echo <<<TEXT
Usage:
    php fixswiftsyncdata.php --help
    php fixswiftsyncdata.php --dry

    --help         : This help message
    --dry		   : generate SQL commands (do not update in database)
    --limit=X	   : Number of records to fix
TEXT;
	exit(0);
}
else {
	fixAllSwiftSyncData( $dry, $limit );
}
