<?php
/**
 * @usage: SERVER_ID=177 php videoPremigrate.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoPremigrate.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */
ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
global $IP, $wgCityId, $wgExternalDatawareDB;
#$IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
echo( "$IP\n" );
echo( "Premigration script running for $wgCityId\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php videoPremigrate.php\n" );
	exit( 0 );
}

//include( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

echo( "Loading list of videos to process\n" );

$rows = $dbw->select('image', 
		array( 'img_name', 'img_metadata' ),
		array( "img_name LIKE ':%'" ),
		__METHOD__
	);

$rowCount = $rows->numRows();
echo(": {$rowCount} videos found\n");

$providers = array(
	4 => 'Fivemin',
	5 => 'Youtube',
	6 => 'Hulu',
	10 => 'Bliptv',
	11 => 'Metacafe',
	13 => 'Vimeo',
	18 => 'Dailymotion',
	19 => 'Viddler',
	21 => 'Screenplay',
	22 => 'Movieclips',
	23 => 'Realgravity',
);

define('STATUS_UNKNOWN', 0);
define('STATUS_OK', 1);
define('STATUS_NOT_SUPPORTED', 2);
define('STATUS_KNOWN_ERROR', 3);
define('STATUS_UNKNOWN_ERROR', 4);

$i = 0;
$timeStart = microtime( true );
if($rowCount) {
	// before processing videos prepare 'status cache'
	// which contains information about previously processed
	// videos on this wiki
	echo "Fetching data about previously processed videos\n";
	$res = $dbw_dataware->select('video_premigrate','*',
		array( 'wiki_id'  => $wgCityId )
	);
	
	$previouslyProcessed = array();
	while($row = $res->fetchRow()) {
		$previouslyProcessed[ $row['img_name'] ] = $row;
	}
	$numb = count($previouslyProcessed);
	echo "Found $numb videos in database\n";
	$dbw_dataware->freeResult($res);
	
	
	// gather backlinks stats
	echo "Getting backlinks for videos\n";
	$backlinks = array();
	$res = $dbr->query("select il_to, count(*) as c from imagelinks where il_to like ':%' group by il_to;");
	while($row = $res->fetchRow()) {
		$backlinks[ $row['il_to'] ] = $row['c'];
	}
	$dbr->freeResult($res);
		
	
	while($video = $dbw->fetchObject($rows)) {
		$i++;
		
		$status = STATUS_UNKNOWN;
		$statusMsg = '';
		$videoName = substr($video->img_name, 1);
		$isNameTaken = 0;
		$meta = '';
		$fullResponse = '';
		$provider = false;
		$thumbnail = '';
		$apiUrl = '';
		$videoOrgId = '';
		$bl = 0;
		
		// check if video was processed previously (regardless of failure type)
		if(isset($previouslyProcessed[$videoName])) {
			$st = $previouslyProcessed[$videoName]['status'];
			if( $st != STATUS_NOT_SUPPORTED && $st != STATUS_UNKNOWN_ERROR ) {
				// those that were not supported - try again, others - skip
				continue;
			}
		}

		// debugging info
		$timeEnd = microtime( true );
		$time = intval( $timeEnd - $timeStart);
		$vps = intval($i / ($timeEnd - $timeStart) * 60);
		$timeString = "[$time s, $vps vpm]";
		echo( "- [$i / $rowCount]\t $timeString \tVideo: {$video->img_name} \n" );
		
		// start processing video
		$titleOrg = Title::newFromText( $videoName, NS_VIDEO );
		$titleNew = Title::newFromText( $videoName, NS_FILE );
		
		if($titleNew && $titleNew->exists() ) {
			echo ("[CONFLICT] Article in NS_FILE namespace already exists\n");
			$isNameTaken = 1;
		}
		$videoOrg = new VideoPage( $titleOrg );
		$videoOrg->load();
		$videoOrgId = $videoOrg->getVideoId();
		$videoOrgProviderId = $videoOrg->getProvider();

		// ugly fix for ugly MW logic
		if ( empty( $videoOrgId ) || empty( $videoOrgProviderId ) ) {

			$titleOrg = Title::newFromText( 'Video:'.$videoName );
			$titleNew = Title::newFromText( 'File:'.$videoName );

			if($titleNew && $titleNew->exists() ) {
				echo ("[CONFLICT] Article in NS_FILE namespace already exists\n");
				$isNameTaken = 1;
			}
			$videoOrg = new VideoPage( $titleOrg );
			$videoOrg->load();
			$videoOrgId = $videoOrg->getVideoId();
			$videoOrgProviderId = $videoOrg->getProvider();
		}
		
		if(isset($backlinks[$video->img_name])) {
			$bl = $backlinks[$video->img_name];
		}
		
		if( !isset( $providers[ $videoOrgProviderId ] ) ) {
			echo ("Provider: unsupported ($videoOrgProviderId)\n");
			$status = STATUS_NOT_SUPPORTED;
		} else {
			$provider = $providers[ $videoOrgProviderId ];
			echo ("Provider: $provider\n");
		
			$retries = 0;
			$retry = true;
			while($retries < 20 && $retry) {
				try {
					$className = ucfirst( $provider ) . 'ApiWrapper';
					if(is_subclass_of($className, 'PseudoApiWrapper')) {
						$apiWrapper = F::build( $className, array( $videoName ) );
					} else {
						$apiWrapper = F::build( $className, array( $videoOrgId ) );
					}
					$meta = $apiWrapper->getMetadata();
					if( $retries == 0 ) {
						echo ("Got data\n");
					} else {
						echo ("Got data after $retries failed tries\n");
					}
					$status = STATUS_OK;
					$thumbnail = $apiWrapper->getThumbnailUrl();
					break;
				}

				catch( VideoNotFoundException $e ) {
					echo ("[ERROR] video not found\n");
					$retry = false;
					$status = STATUS_KNOWN_ERROR;
					$statusMsg = 'NOT_FOUND';
					break;
				}
				catch( VideoIsPrivateException $e ) {
					$retry = false;
					$status = STATUS_KNOWN_ERROR;
					$statusMsg = 'PRIVATE';
					break;
				}
				catch( VideoQuotaExceededException $e ) {
					$retries += 1;
					sleep(2);
					continue;
				}
				catch( NegativeResponseException $e ) {
					$retry = false;
					$status = STATUS_UNKNOWN_ERROR;
					$fullResponse = $e->content;
					break;
				}
				catch( Exception $e ) {
					// unknown error
					$retry = false;
					$status = STATUS_UNKNOWN_ERROR;
					$fullResponse = $e->getMessage();
					if( isset($e->apiUrl) ) {
						$apiUrl = $e->apiUrl;
					}
					break;
				}
			}
			if( $retries == 20 ) {
				echo ("[ERROR] unable to fetch metadata\n");
				$status = STATUS_UNKNOWN_ERROR;
				$statusMsg = 'TOO_MANY_RETRIES';
			}
		}
		
		
		
		// log it
		// TODO
		
		$dbprovider = $provider ? $provider : $videoOrgProviderId;
		if(empty($dbprovider)) {
			$dbprovider = 'EMPTY';
		}
		
		if(isset($previouslyProcessed[$videoName])) {
			// update
			
			// if status was unsupported and still is
			// no need to update
			if( $previouslyProcessed[$videoName]['status'] == STATUS_NOT_SUPPORTED && $status == STATUS_NOT_SUPPORTED ) {
				continue;
			}
			
			$dbw_dataware->update('video_premigrate',
				array( 
					'provider' 		=> $dbprovider,
					'new_metadata'	=> serialize($meta),
					'is_name_taken'	=> $isNameTaken,
					'status'		=> $status,
					'status_msg'	=> $statusMsg,
					'full_response'	=> serialize($fullResponse),
					'thumbnail_url'	=> $thumbnail,
					'api_url'		=> $apiUrl,
					'video_id'		=> $videoOrgId,
					'backlinks'		=> $bl,
				),
				array( 
					'img_name'		=> $videoName,
					'wiki_id'		=> $wgCityId,
				)
			);
		} else {
			// insert
			$dbw_dataware->insert('video_premigrate', 
				array( 
					'img_name'		=> $videoName,
					'wiki_id'		=> $wgCityId,
					'provider'		=> $dbprovider,
					'new_metadata'	=> serialize($meta),
					'is_name_taken'	=> $isNameTaken,
					'status'		=> $status,
					'status_msg'	=> $statusMsg,
					'full_response'	=> serialize($fullResponse),
					'thumbnail_url'	=> $thumbnail,
					'api_url'		=> $apiUrl,
					'video_id'		=> $videoOrgId,
					'backlinks'		=> $bl,
				)
			);
		}
	}

	echo("\nDone\n");
}
else {
	echo("Nothing to do\n");
}

$dbw->freeResult($rows);

echo(": {$rowCount} videos processed.\n");


?>
