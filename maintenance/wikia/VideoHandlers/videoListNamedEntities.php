<?php
/** @usage: SERVER_ID=298117 php ./videoListNamedEntities.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php */

ini_set( 'display_errors', 'stdout' );
$options = array('help');

require_once( '../../commandLine.inc' );

global $wgCityId, $wgExternalDatawareDB;

$dbw = wfGetDB( DB_SLAVE );
echo( "Loading list of videos to process\n" );

$rows = $dbw->select( 'image',
		array( 'img_name', 'img_metadata', 'img_major_mime', 'img_minor_mime' ),
		array( " img_major_mime='video'
			AND (
					img_metadata like '%named_entities%'
			    )
			 "),
		__METHOD__
);

$rowCount = $rows->numRows();
echo(": {$rowCount} videos found\n");

if( $rowCount ) {

	while( $videoRow = $dbw->fetchObject($rows) ) {
		$meta = unserialize( $videoRow->img_metadata );
		if ( isset( $meta['named_entities']) && count($meta['named_entities']) > 0 ) {
			foreach ( $meta['named_entities'] as $m )
				echo  $m['type'] . " - " . $m['value'] . "\n";
		}
	}

	echo "Done\n";
}
$dbw->freeResult($rows);


