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


// $IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
// echo( "$IP\n" );

global $wgCityId, $wgExternalDatawareDB;

echo( "Video Migration script running for $wgCityId\n" );
videoLog( 'migration', 'START', '');

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoMigrationData.php\n" );
	exit( 0 );
}

$defaultThumbnailUrl = 'http://images4.wikia.nocookie.net/szeryftest/images/0/0a/Videoclip.jpg'; // TODO: CHANGEME


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
		$file->forceMime( 'video/'.strtolower( $provider ) );
		$file->forceMetadata( serialize($metadata) );
		
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


echo "Migrating RelatedVideos from cross-wiki links to regular links\n";

$botUser = User::newFromName( 'WikiaBot' );

$i=0;
$rows = $dbw->query( 'select page_id FROM page WHERE page_namespace = 1100' );
while( $page = $dbw->fetchObject($rows) ) {
	$articleId = $page->page_id;
	$oTitle = Title::newFromId( $articleId );
	if ( $oTitle instanceof Title && $oTitle->exists() ){
		global $wgTitle;
		// in some cases hooks depend on wgTitle (hook for article edit)
		// but normally it wouldn't be set for maintenance script
		$wgTitle = $oTitle;
		$oArticle = new Article ( $oTitle );
		if ( $oArticle instanceof Article ){
			$sTextAfter = $sText = $oArticle->getContent();
			$sTextAfter = str_replace( '* VW:', '* ', $sTextAfter  );

			if ( $sTextAfter != $sText ) {
				echo "ARTICLE WAS CHANGED! \n";
				$status = $oArticle->doEdit( $sTextAfter, 'Changing cross-wiki links to local links', EDIT_MINOR | EDIT_UPDATE | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
				$i++;
			}
		}
	}
}

echo "Done\n";
videoLog( 'migration', 'RELATEDVIDEOS', "edits:$i");
videoLog( 'migration', 'STOP', "");


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
