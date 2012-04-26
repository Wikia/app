<?php
/**
 * @usage: sudo -u www-data SERVER_ID=177 php videoMigrateData.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: sudo -u www-data SERVER_ID=177 php videoMigrateData.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */

ini_set( 'display_errors', 'stdout' );
$options = array('help');

require_once( '../../commandLine.inc' );
require_once( 'premigrate.class.php' );
require_once( 'videolog.class.php' );

function adjustThumbnailToVideoRatio( $upload, $ratio ){
	if(empty($ratio)) {
		$ratio = 16/9;
	}

	$data = file_get_contents( $upload->getTempPath() );
	$src = imagecreatefromstring( $data );

	$orgWidth = $upload->mFileProps['width'];
	$orgHeight = $upload->mFileProps['height'];
	$finalWidth = $upload->mFileProps['width'];
	$finalHeight = $finalWidth / $ratio;

	$dest = imagecreatetruecolor ( $finalWidth, $finalHeight );
	imagecopy( $dest, $src, 0, 0, 0, ( $orgHeight - $finalHeight ) / 2 , $finalWidth, $finalHeight );

	$sTmpPath = $upload->getTempPath();
	switch ( $upload->mFileProps['minor_mime'] ) {
		case 'jpeg':	imagejpeg( $dest, $sTmpPath ); break;
		case 'gif':	imagegif ( $dest, $sTmpPath ); break;
		case 'png':	imagepng ( $dest, $sTmpPath ); break;
	}

	imagedestroy( $src );
	imagedestroy( $dest );

}

global $wgCityId, $wgExternalDatawareDB;

echo( "Video Migration script running for $wgCityId\n" );
videoLog( 'reupload', 'START', '');

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoReupload.php\n" );
	exit( 0 );
}

$defaultThumbnailUrl = 'http://community.wikia.com/extensions/wikia/VideoHandlers/images/BrokenVideo_Icon_Large.png'; // TODO: CHANGEME


//@include( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

//$dbw = WikiFactory::db( DB_MASTER );
$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

echo( "Loading list of videos to process\n" );

$rows = $dbw->select( 'image',
		array( 'img_name', 'img_metadata', 'img_major_mime', 'img_minor_mime' ),
		array( " img_major_mime='video' AND img_name NOT LIKE ':%' AND img_minor_mime='viddler' AND img_name='Danny_Jacobs_Interview' "),
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
		//$videoId = is_subclass_of($apiWrapperName, 'PseudoApiWrapper') ? $videoRow->img_name : $metadata['videoId'];
		$videoId = $metadata['videoId'];
		$result = null;
		$status = "fail";

		try {
			echo "reuploading: [from:".$provider." videoId:$videoId] - ".$videoRow->img_name."\n";
			echo "title: " . $title . "\n";
			//$result = VideoFileUploader::uploadVideo($provider, $videoId, $title, null, true);
			$oUploader = new VideoFileUploader();
			$oUploader->setProvider( $provider );
			$oUploader->setVideoId( $videoId );
			$oUploader->setDescription( null );
			$oUploader->setTargetTitle( $title );
			$oUploader->hideAction();
			$oUploader->upload( $title );

			//var_dump($result);

		} catch( Exception $e ) {
			echo ("ERROR FETCHING DATA: [{$videoRow->img_minor_mime}]". $videoRow->img_name . "\n");
			echo $e->getMessage() ."\n";
		}


		/*
		$apiWrapper = null;
		try {
			$apiWrapperName = ucfirst( $videoRow->img_minor_mime ) . 'ApiWrapper';

			if(is_subclass_of($apiWrapperName, 'PseudoApiWrapper')) {
				$apiWrapper = F::build( $apiWrapperName, array( $videoRow->img_name ) );
			} else {
				$apiWrapper = F::build( $apiWrapperName, array( $metadata['videoId'] ) );
			}

			$meta = $apiWrapper->getMetadata();
			$thumbanilUrl = $apiWrapper->getThumbnailUrl();

			echo "Thumbnail: {$thumbanilUrl} \n";
		}
		catch( Exception $e ) {
			echo ("ERROR FETCHING DATA: [{$videoRow->img_minor_mime}]". $videoRow->img_name . "\n");
			break;
		}
		*/


		echo("\n ========================================== \n");
	}

	echo "Done\n";
}
$dbw_dataware->freeResult($rows);

echo(": {$rowCount} videos processed.\n");

echo "Done\n";

videoLog( 'reupload', 'STOP', "");


wfWaitForSlaves( 2 );
?>