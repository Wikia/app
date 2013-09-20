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



// $IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
// echo( "$IP\n" );

global $wgCityId, $wgExternalDatawareDB;

echo( "Video Migration script running for $wgCityId\n" );
videoLog( 'migration', 'START', '');

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoMigrationData.php\n" );
	exit( 0 );
}

$defaultThumbnailUrl = 'http://community.wikia.com/extensions/wikia/VideoHandlers/images/BrokenVideo_Icon_Large.png'; // TODO: CHANGEME
$botUser = User::newFromName( 'WikiaBot' );

//@include( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

//$dbw = WikiFactory::db( DB_MASTER );
$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

echo( "Loading list of videos to process\n" );

$rows = $dbw_dataware->select( 'video_premigrate',
	array( 'img_name', 'provider', 'new_metadata', 'thumbnail_url', 'video_id' ),
	array( "(status = 1 OR backlinks > 0) AND is_name_taken = 0 AND wiki_id = $wgCityId"),
	__METHOD__
);

$rowCount = $rows->numRows();
echo(": {$rowCount} videos found\n");


/* cache premigration data for videos */
$premigration_cache = array();
while( $video = $dbw_dataware->fetchObject($rows) ) {
	$premigration_cache[ $video->img_name ] = $video;
}

$dbw_dataware->freeResult( $rows );

$failures = array();

$i = 0;
$er = 0;
$timeStart = microtime( true );
if( $rowCount ) {
	// before processing videos prepare 'status cache'
	// which contains information about previously processed
	// videos on this wiki
	echo "Fetching data about previously processed videos\n";

	$existingRows = $dbw->query( 'select img_name FROM image WHERE img_major_mime = "video" AND  img_name NOT LIKE ":%"' );

	$alreadyExisting = array();
	while($row = $existingRows->fetchObject()) {
		$alreadyExisting[] = $row->img_name;
	}
	$numb = count( $alreadyExisting );

	echo "Found $numb videos already migrated\n";
	$dbw_dataware->freeResult($existingRows);

	premigrate::initialize();

	$rows = $dbw->query( 'select img_name FROM image WHERE img_name LIKE ":%"' );
	while( $video_name = $dbw->fetchObject($rows) ) {
		// check if video was processed previously (regardless of failure type)
		if( in_array( $video_name->img_name, $alreadyExisting ) ) {
			//echo "Aleardy migrated\n";
			continue;
		}

		// check if we have premigration data
		// (this shouldn't happen, because this script is supposed to be
		//  run right after premigration)
		$videoName = substr($video_name->img_name, 1);
		$video = null;
		if( !isset($premigration_cache[ $videoName ] ) ) {
			echo "NO DATA FOR VIDEO!\n";
			$video = premigrate::processVideo( $video_name->img_name );
		} else {
			$video = $premigration_cache[ $videoName ];
		}

		$i++;
		if ( !in_array( $video->provider, $wgVideoMigrationProviderMap ) ){
			echo "Unreconizable provider {$video->provider}\n";
			$failures[] = 'Unreconizable provider :' . $video->provider . ' in '. $video->img_name;
			continue;
		}

		if ( $video->provider != "Screenplay" ) {
			// only handle RealGravity
			continue;
		} else {
			echo "Found Screenplay\n";
			sleep(1);
		}

		// debugging info

		$timeEnd = microtime( true );
		$time = intval( $timeEnd - $timeStart);
		$vps = intval($i / ($timeEnd - $timeStart) * 60);
		$timeString = "[$time s, $vps vpm]";
		echo( "- [$i / $rowCount]\t $timeString \tVideo: {$video->img_name} \n" );

		// start processing video

		$provider = $video->provider;
		$undercover = true;
		$metadata = unserialize( $video->new_metadata );
		if ( empty( $metadata['videoId'] ) ){
			$failures[] = 'Empty Video ID for :' . $video->img_name;
			continue;
		}

		$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => !empty( $video->thumbnail_url ) ? $video->thumbnail_url : $defaultThumbnailUrl
		);

		$upload = (new UploadFromUrl); /* @var $upload UploadFromUrl */
		$upload->initializeFromRequest( new FauxRequest( $data, true ) );
		$upload->fetchFile();
		$res = $upload->verifyUpload();

		if( is_array($res) && ($res['status'] != UploadFromUrl::OK && $res['status'] != UploadFromUrl::VERIFICATION_ERROR) ) {
			$data = array(
				'wpUpload' => 1,
				'wpSourceType' => 'web',
				'wpUploadFileURL' => $defaultThumbnailUrl
			);
			$upload = (new UploadFromUrl);
			$upload->initializeFromRequest( new FauxRequest( $data, true ) );
			$upload->fetchFile();
			$res = $upload->verifyUpload();
			echo "Using default thumbnail (could not get from url: " . $video->thumbnail_url . " )\n";
		}

		if( !is_array($res) || ($res['status'] != UploadFromUrl::OK && $res['status'] != UploadFromUrl::VERIFICATION_ERROR) ) {
			echo "Thumbnail upload fail\n";
			var_dump( $res );
			continue;
		}

		adjustThumbnailToVideoRatio( $upload, $metadata['aspectRatio'] );

		/* create a reference to article that will contain uploaded file */
		$title = Title::newFromText( $video->img_name, NS_FILE );

		$class = !empty( $undercover )
			? 'WikiaNoArticleLocalFile'
			: 'WikiaLocalFile';
		$file = new $class( $title, RepoGroup::singleton()->getLocalRepo() );
		/* @var $file WikiaLocalFile */

		/* override thumbnail metadata with video metadata */
		$file->setVideoId( $metadata['videoId'] );
		$file->forceMime( 'video/'.strtolower( $provider ) );
		$file->forceMetadata( serialize($metadata) );

		/* real upload */
		$result = $file->upload(
			$upload->getTempPath(),
			'',
			'',
			File::DELETE_SOURCE,
			false,
			false,
			$botUser
		);

		if ( $result->ok ){
			// echo( "- Success! \n" );
		} else {
			$failures[] = 'Upload failed :' . $video->img_name;
			var_dump( $result );
			echo( "- Failure! \n" );
			$er++;
		}

	}
	echo("\nDone\n");
}
else {
	echo("Nothing to do\n");
}

$dbw_dataware->freeResult($rows);

echo(": {$rowCount} videos processed.\n");
videoLog( 'migration', 'MIGRATED', "migrated:$i,total:$rowCount,errors:$er");


videoLog( 'migration', 'STOP', "");


foreach ( $failures as $failure ){
	echo ( "$failure \n" );
}

wfWaitForSlaves( 2 );

/*
 * wywala nam sie upload
 * check if new name will be available
 * change in page
 * upload
 * success -> change in all backlinking articles
 */
?>
