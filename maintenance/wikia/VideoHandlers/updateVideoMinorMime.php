<?php

/**
* Maintenance script to update minor mime type (video)
* This is one time use script
* @author Saipetch Kongkatong
*/

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

if ( isset($options['help']) ) {
	die( "Usage: php updateVideo.php [--help] [--dry-run] [--old=name] [--new=name]
	--dry-run                      dry run
	--old                          old minor mime type
	--new                          new minor mime type
	--help                         you are reading it right now\n\n" );
}

if ( empty($wgCityId) ) {
	die( "Error: Invalid wiki id.\n" );
}

if ( empty($options['old']) ) {
	die( "Error: Please enter old data.\n" );
}

if ( empty($options['new']) ) {
	die( "Error: Please enter new data.\n" );
}

$old = $options['old'];
$new = $options['new'];
$dryRun = isset($options['dry-run']);

echo "Change from '$old' to '$new'.\n";
echo "Wiki: $wgCityId ($wgDBname)\n";

$dbw = wfGetDB( DB_MASTER );

$result = $dbw->select(
	array( 'image' ),
	array( 'img_name', 'img_metadata' ),
	array(
		'img_media_type' => 'VIDEO',
		'img_minor_mime' => $old,
	),
	__METHOD__
);

$total = $result->numRows();
$success = 0;
$failed = 0;
while ( $row = $dbw->fetchObject($result) ) {
	$name = $row->img_name;
	echo "Name: $name";

	$title = Title::newFromText( $name, NS_FILE );
	if ( !$title instanceof Title ) {
		$failed++;
		echo "...FAILED. (Error: Title NOT found)\n";
		continue;
	}

	$file = wfFindFile( $title );
	if ( empty($file) ) {
		$failed++;
		echo "...FAILED. (Error: File NOT found)\n";
		continue;
	}

	if ( !$dryRun ) {
		// update database
		$dbw->update( 'image',
			array( 'img_minor_mime' => $new ),
			array( 'img_name' => $name ),
			__METHOD__
		);

		// clear cache
		$file->purgeEverything();
	}

	$success++;
	echo "...DONE.\n";
}

echo "Total Videos: {$total}, Success: {$success}, Failed: {$failed}.\n\n";