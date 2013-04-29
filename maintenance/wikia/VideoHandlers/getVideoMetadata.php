<?php

/**
* Maintenance script to get video data by provider and export to csv file
* @author Saipetch Kongkatong
*/

/**
 * add data to video
 * @param array $row
 * @param array $fields
 * @param array $video
 * @return array $video
 */
function addDataToVideo( $row, $fields, $video = array() ) {
	foreach( $fields as $key => $value ) {
		$data = empty( $row[$value] ) ? '' : $row[$value];
		$video[] = $data;
		printText( "\t$key: $data\n" );
	}

	return $video;
}

/**
 * write data to file (csv)
 * @global boolean $export
 * @global file pointer $fp
 * @param array $data
 */
function writeToFile( $data ) {
	global $export, $fp;

	if ( $export ) {
		fputcsv( $fp, $data );
	}
}

/**
 * print text if not in quiet mode
 * @global type $quiet
 * @param type $text
 */
function printText( $text ) {
	global $quiet;

	if ( !$quiet ) {
		echo $text;
	}
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set( "display_errors", 1 );

require_once( "commandLine.inc" );

if ( isset($options['help']) ) {
	die( "Usage: php getVideoMetadata.php [--help] [--provider=xyz] [--export]
	--provider               provider name (required)
	--export                 export to csv file (path = /tmp/video_metadata_<provider>.csv)
	--quiet                  show summary result only
	--help                   you are reading it right now\n\n" );
}

$provider = isset( $options['provider'] ) ? $options['provider'] : '';
$export = isset( $options['export'] );
$quiet = isset( $options['quiet'] );

if ( empty( $wgCityId ) ) {
	die( "Error: Invalid wiki id.\n" );
}

echo "Wiki: $wgCityId\n";

if ( empty( $provider ) ) {
	die( "Error: Invalid provider.\n" );
}

echo "Provider: $provider\n";

if ( $export ) {
	$filename = '/tmp/video_metadata_'.$provider.'.csv';
	$fp = fopen( $filename, 'w' );

	echo "Export to file: $filename\n";
}

// fields to be included (from fields in image table)
$fieldMain = array(
	'Title' => 'img_name',
	'Partner' => 'img_minor_mime',
);

// fields to be included (come from img_metadata)
$fieldMeta = array(
	'Description' => 'description',
	'Keywords' => 'keywords',
);

$header = array_merge( array_keys( $fieldMain ), array_keys( $fieldMeta ) );
writeToFile( $header );

$limit = 1000;
$total = 1;
$lastTitle = '';

$db = wfGetDB( DB_SLAVE );

do {
	$result = $db->select(
		array( 'image' ),
		array( '*' ),
		array(
			'img_media_type' => 'VIDEO',
			'img_minor_mime' => $provider,
			'img_name > '.$db->addQuotes( $lastTitle ),
		),
		__METHOD__,
		array( 'LIMIT' => $limit )
	);

	$cnt = 1;
	$subTotal = $result->numRows();

	while ( $row = $db->fetchRow( $result ) ) {
		echo "\n[Total: $total ($cnt of $subTotal)] Video: $row[img_name]\n";

		$videoMain = addDataToVideo( $row, $fieldMain );

		$metaData = unserialize( $row['img_metadata'] ) ;
		$video = addDataToVideo( $metaData, $fieldMeta, $videoMain );

		writeToFile( $video );

		$lastTitle = $row['img_name'];

		$cnt++;
		$total++;
	}
} while ( $subTotal );

$db->freeResult( $result );

if ( $export ) {
	fclose( $fp );
}

echo "\nWiki: $wgCityId, Provider: $provider, Total Videos: ".( $total - 1 ).".\n\n";
