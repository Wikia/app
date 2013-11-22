<?php

$providers = $wgVideoMigrationProviderMap;

/*$providers = array(
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
);*/

define('STATUS_UNKNOWN', 0);
define('STATUS_OK', 1);
define('STATUS_NOT_SUPPORTED', 2);
define('STATUS_KNOWN_ERROR', 3);
define('STATUS_UNKNOWN_ERROR', 4);

class Premigrate {

	static $previouslyProcessed	= array();
	static $backlinks		= array();


	static function initialize() {
		global $wgExternalDatawareDB, $wgCityId;
		$dbr = wfGetDB( DB_SLAVE );
		$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		// before processing videos prepare 'status cache'
		// which contains information about previously processed
		// videos on this wiki
		echo "Fetching data about previously processed videos (premigration)\n";
		$res = $dbw_dataware->select('video_premigrate','*',
			array( 'wiki_id'  => $wgCityId )
		);

		while($row = $res->fetchRow()) {
			static::$previouslyProcessed[ $row['img_name'] ] = $row;
		}
		$numb = count(static::$previouslyProcessed);
		echo "Found $numb videos in database\n";
		$dbw_dataware->freeResult($res);


		// gather backlinks stats
		echo "Getting backlinks for videos\n";
		static::$backlinks = array();
		$res = $dbr->query("select il_to, count(*) as c from imagelinks where il_to like ':%' group by il_to;");
		while($row = $res->fetchRow()) {
			static::$backlinks[ $row['il_to'] ] = $row['c'];
		}
		$dbr->freeResult($res);
	}

	static function needsProcessing( $raw_video_name ) {
		$videoName		= substr($raw_video_name, 1);
		// check if video was processed previously (regardless of failure type)
		if(isset(static::$previouslyProcessed[$videoName])) {
			$st = static::$previouslyProcessed[$videoName]['status'];
			if( $st != STATUS_NOT_SUPPORTED && $st != STATUS_UNKNOWN_ERROR ) {
				// those that were not supported - try again, others - skip
				return false;
			}
		}
		return true;
	}

	static function processVideo( $raw_video_name ) {
		global $wgExternalDatawareDB, $wgCityId, $providers;
		$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		$status			= STATUS_UNKNOWN;
		$statusMsg		= '';
		$videoName		= substr($raw_video_name, 1);
		$isNameTaken	= 0;
		$meta			= '';
		$fullResponse	= '';
		$provider		= false;
		$thumbnail		= '';
		$apiUrl			= '';
		$videoOrgId		= '';
		$bl				= 0;


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

		if(isset($backlinks[$raw_video_name])) {
			$bl = $backlinks[$raw_video_name];
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
						$apiWrapper = new $className( $videoName );
					} else {
						$apiWrapper = new $className( $videoOrgId );
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
					if(!is_subclass_of($className, 'PseudoApiWrapper')) {
						// if a video failed that used regular provider
						// just get fake metadata (from old entry)
						$apiWrapper = new FakeApiWrapper( $videoName );
						$meta = $apiWrapper->getMetadata();
					}
					break;
				}
				catch( VideoIsPrivateException $e ) {
					echo ("[ERROR] video is private\n");
					$retry = false;
					$status = STATUS_KNOWN_ERROR;
					$statusMsg = 'PRIVATE';
					if(!is_subclass_of($className, 'PseudoApiWrapper')) {
						// if a video failed that used regular provider
						// just get fake metadata (from old entry)
						$apiWrapper = new FakeApiWrapper( $videoName );
						$meta = $apiWrapper->getMetadata();
					}
					break;
				}
				catch( VideoQuotaExceededException $e ) {
					echo ("[ERROR] quota exceeded, will retry\n");
					$retries += 1;
					sleep(2);
					continue;
				}
				catch( NegativeResponseException $e ) {
					echo ("[ERROR] negative response\n");
					$retry = false;
					$status = STATUS_UNKNOWN_ERROR;
					$fullResponse = $e->content;
					if(!is_subclass_of($className, 'PseudoApiWrapper')) {
						// if a video failed that used regular provider
						// just get fake metadata (from old entry)
						$apiWrapper = new FakeApiWrapper( $videoName );
						$meta = $apiWrapper->getMetadata();
					}
					break;
				}
				catch( Exception $e ) {
					echo ("[ERROR] Unknown error: ". $e->getMessage() . "\n");
					// unknown error
					$retry = false;
					$status = STATUS_UNKNOWN_ERROR;
					$fullResponse = $e->getMessage();
					if( isset($e->apiUrl) ) {
						$apiUrl = $e->apiUrl;
					}
					if(!is_subclass_of($className, 'PseudoApiWrapper')) {
						// if a video failed that used regular provider
						// just get fake metadata (from old entry)
						$apiWrapper = new FakeApiWrapper( $videoName );
						$meta = $apiWrapper->getMetadata();
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



		$dbprovider = $provider ? $provider : $videoOrgProviderId;
		if(empty($dbprovider)) {
			$dbprovider = 'EMPTY';
		}

		$video = array(
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
		);

		if(isset(static::$previouslyProcessed[$videoName])) {
			// update

			// if status was unsupported and still is
			// no need to update
			if( static::$previouslyProcessed[$videoName]['status'] == STATUS_NOT_SUPPORTED && $status == STATUS_NOT_SUPPORTED ) {
				return (object)$video;
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
			$dbw_dataware->insert('video_premigrate', $video );
		}

		return (object)$video;
	}
}