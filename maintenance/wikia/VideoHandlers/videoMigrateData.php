<?php
/**
 * @usage: sudo -u www-data SERVER_ID=177 php videoMigrateData.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: sudo -u www-data SERVER_ID=177 php videoMigrateData.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
// $IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
// echo( "$IP\n" );

echo( "Video Migration script running for $wgCityId\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoMigrationData.php\n" );
	exit( 0 );
}

$defaultThumbnailUrl = 'http://images4.wikia.nocookie.net/szeryftest/images/0/0a/Videoclip.jpg'; // CHANGEME


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

$providers = $wgVideoMigrationProviderMap;

define('STATUS_UNKNOWN', 0);
define('STATUS_OK', 1);
define('STATUS_NOT_SUPPORTED', 2);
define('STATUS_KNOWN_ERROR', 3);
define('STATUS_UNKNOWN_ERROR', 4);

$failures = array();

$i = 0;
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
//

	while( $video = $dbw_dataware->fetchObject($rows) ) {
		// check if video was processed previously (regardless of failure type)
		if( in_array( $video->img_name, $alreadyExisting ) ) {
			//echo "Aleardy migrated\n";
			continue;
		}
		$i++;
		if ( !in_array( $video->provider, $wgVideoMigrationProviderMap ) ){
			echo "Unreconizable provider {$video->provider}\n";
			$failures[] = 'Unreconizable provider :' . $video->provider . ' in '. $video->img_name;
			continue;
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
		$upload = F::build( 'UploadFromUrl' );
		$upload->initializeFromRequest( F::build( 'FauxRequest', array( $data, true ) ) );
		$upload->fetchFile();
		$upload->verifyUpload();

		/* create a reference to article that will contain uploaded file */
		$title = Title::newFromText( $video->img_name, NS_FILE );

		$file = F::build(
				!empty( $undercover )
					? 'WikiaNoArticleLocalFile'
					: 'WikiaLocalFile',
				array(	$title, RepoGroup::singleton()->getLocalRepo() )
			);

		/* override thumbnail metadata with video metadata */
		$file->setVideoId( $metadata['videoId'] );
		$file->forceMime( 'video/'.strtolower( $provider ), serialize($metadata) );
		
		/* real upload */
		$result = $file->upload(
				$upload->getTempPath(),
				'',
				'',
				File::DELETE_SOURCE
			);

		if ( $result->ok ){
			// echo( "- Success! \n" );
		} else {
			$failures[] = 'Upload failed :' . $video->img_name;
			var_dump( $result );
			echo( "- Failure! \n" );
		}

	}
	echo("\nDone\n");
}
else {
	echo("Nothing to do\n");
}

$dbw_dataware->freeResult($rows);

echo(": {$rowCount} videos processed.\n");

foreach ( $failures as $failure ){
	echo ( "$failure \n" );
}
/*
 * wywala nam sie upload
 * check if new name will be available
 * change in page
 * upload
 * success -> change in all backlinking articles
 */
?>
