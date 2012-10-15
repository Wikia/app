<?php
/**
 * @usage: sudo -u www-data SERVER_ID=177 php videoMigrateData.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: sudo -u www-data SERVER_ID=177 php videoMigrateData.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */

ini_set( 'display_errors', 'stdout' );
$options = array('help');

require_once( '../../commandLine.inc' );

global $wgCityId, $wgExternalDatawareDB;

echo( "Video Migration script running for $wgCityId\n" );


if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoReupload.php\n" );
	exit( 0 );
}

//@include( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

//$dbw = WikiFactory::db( DB_MASTER );
$dbw = wfGetDB( DB_MASTER );

echo( "Loading list of videos to process\n" );

$rows = $dbw->select( 'image',
		array( 'img_name', 'img_metadata', 'img_major_mime', 'img_minor_mime' ),
		array( " img_major_mime='video'
			AND img_name NOT LIKE ':%'
			AND (
				img_minor_mime IN ('viddler','gametrailers','sevenload','southparkstudios')
				OR
				(img_width=0 AND img_height=0)
			    )
			 "),
		__METHOD__
);

$wgUser = User::newFromName('WikiaBot');

$rowCount = $rows->numRows();
echo(": {$rowCount} videos found\n");

if( $rowCount ) {

	while( $videoRow = $dbw->fetchObject($rows) ) {


		$provider = $videoRow->img_minor_mime;
		$undercover = true;
		$metadata = unserialize( $videoRow->img_metadata );
		if ( empty( $metadata['videoId'] ) ){
			$failures[] = 'Empty Video ID for :' . $video->img_name;
			continue;
		}

		echo "Img name: ".$videoRow->img_name." \n ";
		$title = Title::newFromDBkey($videoRow->img_name);

		$provider = $videoRow->img_minor_mime;
		$apiWrapperName = ucfirst( $videoRow->img_minor_mime ) . 'ApiWrapper';
		$videoId = $metadata['videoId'];
		$result = null;
		$status = "fail";

		echo "reuploading: [from:".$provider." videoId:$videoId] - ".$videoRow->img_name."\n";
		echo "title: " . $title . "\n";

		try {
			$oUploader = new VideoFileUploader();
			$oUploader->setProvider( $provider );
			$oUploader->setVideoId( $videoId );
			$oUploader->setDescription( null );
			$oUploader->setTargetTitle( $title );
			$oUploader->hideAction();
			$oUploader->upload( $title );

		} catch( Exception $e ) {

			echo ("ERROR FETCHING DATA: [{$videoRow->img_minor_mime}]". $videoRow->img_name . "\n");
			echo $e->getMessage() ."\n";
		}

		echo("========================================== \n");
	}

	echo "Done\n";
}
$dbw->freeResult($rows);

echo(": {$rowCount} videos processed.\n");

echo "Done\n";

wfWaitForSlaves( 2 );
?>