<?php

/**
 * Class VideoFeedIngester
 */
abstract class VideoFeedIngester {

	// Caching constants; all integers are seconds
	const CACHE_KEY = 'videofeedingester-2';
	const CACHE_EXPIRY = 3600;
	const THROTTLE_INTERVAL = 1;

	// Names a city variable to look for additional category data.  Used in the reingestBrokenVideo.php
	const WIKI_INGESTION_DATA_VARNAME = 'wgPartnerVideoIngestionData';

	// Determines if a duplicate video found should be re-uploaded or ignored
	public $reupload = false;

	protected static $API_WRAPPER;
	protected static $PROVIDER;
	protected static $FEED_URL;
	protected static $CLIP_FILTER = array();
	protected $filterByProviderVideoId = array();

	protected $defaultRequestOptions = [
		'noProxy' => true
	];

	private static $WIKI_INGESTION_DATA_FIELDS = array( 'keyphrases' );

	/** @var  IngesterDataNormalizer */
	private $dataNormalizer;
	private $debug;
	protected $videoData;

	public function __construct( $dataNormalizer, $debug = false, FeedIngesterLogger $logger ) {
		$this->dataNormalizer = $dataNormalizer;
		$this->debug = $debug;
		$this->logger = $logger;
	}

	protected function debugMode() {
		return $this->debug;
	}

	abstract public function import( $content = '', $params = array() );

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $data - Video data
	 * @param $addlCategories - Any additional categories to add
	 * @return array - A list of category names
	 */
	abstract public function generateCategories( array $data, $addlCategories );

	/**
	 * Generate name for video.
	 * Note: The name is not sanitized for use as filename or article title.
	 * @return string video name
	 */
	protected function generateName() {
		return $this->videoData['titleName'];
	}

	/**
	 * generate the metadata we consider interesting for this video
	 * Note: metadata is array instead of object because it's stored in the database as a serialized array,
	 *       and serialized objects would have more version issues.
	 * @param $errorMsg - Store any error we encounter
	 * @return array|int - An associative array of meta data or zero on error
	 */
	public function generateMetadata( &$errorMsg ) {
		if ( empty( $this->videoData['videoId'] ) ) {
			$errorMsg = 'no video id exists';
			return 0;
		}

		$metaData = [
			'videoId'              => $this->videoData['videoId'],
			'altVideoId'           => isset( $this->videoData['altVideoId'] ) ? $this->videoData['altVideoId'] : '',
			'hd'                   => isset( $this->videoData['hd'] ) ? $this->videoData['hd'] : 0,
			'duration'             => isset( $this->videoData['duration'] ) ? $this->videoData['duration'] : '',
			'published'            => isset( $this->videoData['published'] ) ? $this->videoData['published'] : '',
			'thumbnail'            => isset( $this->videoData['thumbnail'] ) ? $this->videoData['thumbnail'] : '',
			'description'          => isset( $this->videoData['description'] ) ? $this->videoData['description'] : '',
			'name'                 => isset( $this->videoData['name'] ) ? $this->videoData['name'] : '',
			'type'                 => isset( $this->videoData['type'] ) ? $this->videoData['type'] : '',
			'category'             => isset( $this->videoData['category'] ) ? $this->videoData['category'] : '',
			'keywords'             => isset( $this->videoData['keywords'] ) ? $this->videoData['keywords'] : '',
			'industryRating'       => isset( $this->videoData['industryRating'] ) ? $this->videoData['industryRating'] : '',
			'ageGate'              => isset( $this->videoData['ageGate'] ) ? $this->videoData['ageGate'] : 0,
			'ageRequired'          => isset( $this->videoData['ageRequired'] ) ? $this->videoData['ageRequired'] : 0,
			'provider'             => isset( $this->videoData['provider'] ) ? $this->videoData['provider'] : '',
			'language'             => isset( $this->videoData['language'] ) ? $this->videoData['language'] : '',
			'subtitle'             => isset( $this->videoData['subtitle'] ) ? $this->videoData['subtitle'] : '',
			'genres'               => isset( $this->videoData['genres'] ) ? $this->videoData['genres'] : '',
			'actors'               => isset( $this->videoData['actors'] ) ? $this->videoData['actors'] : '',
			'targetCountry'        => isset( $this->videoData['targetCountry'] ) ? $this->videoData['targetCountry'] : '',
			'series'               => isset( $this->videoData['series'] ) ? $this->videoData['series'] : '',
			'season'               => isset( $this->videoData['season'] ) ? $this->videoData['season'] : '',
			'episode'              => isset( $this->videoData['episode'] ) ? $this->videoData['episode'] : '',
			'characters'           => isset( $this->videoData['characters'] ) ? $this->videoData['characters'] : '',
			'resolution'           => isset( $this->videoData['resolution'] ) ? $this->videoData['resolution'] : '',
			'aspectRatio'          => isset( $this->videoData['aspectRatio'] ) ? $this->videoData['aspectRatio'] : '',
			'expirationDate'       => isset( $this->videoData['expirationDate'] ) ? $this->videoData['expirationDate'] : '',
			'regionalRestrictions' => isset( $this->videoData['regionalRestrictions'] ) ? $this->videoData['regionalRestrictions'] : '',
		];

		return $metaData;
	}

	/**
	 *  If  $this->filterByProviderVideoId  is not empty, the ingestion script will only upload the videos
	 *  that are in the array
	 * @param $id
	 */
	public function setFilter( $id ) {

		if ( !in_array( $id, $this->filterByProviderVideoId ) ) {
			$this->filterByProviderVideoId[] = $id;
		}
	}

	protected function setVideoData( $videoData ) {
		$this->videoData = $videoData;
	}

	// TODO fix this logic up a bit
	public function shouldSkipVideo() {

		// See if this video is blacklisted (exact match against any data)
		if ( $this->isBlacklistedVideo() ) {
			$this->logger->videoSkipped( "Skipping (video is blacklisted) '{$this->videoData['titleName']}' - {$this->videoData['description']}.\n" );
			return true;
		}

		// See if this video should be filtered (regex match against specific fields)
		if ( $this->isFilteredVideo() ) {
			$this->logger->videoSkipped( "Skipping (video filtered based on metadata) '{$this->videoData['titleName']}' - {$this->videoData['description']}.\n" );
			return true;
		}

		return false;
	}

	public function printInitialData() {
		if ( $this->debugMode() ) {
			print "data after initial processing: \n";
			foreach ( explode( "\n", var_export( $this->videoData, 1 ) ) as $line ) {
				print ":: $line\n";
			}
		}
	}

	/**
	 * @param array $videoData
	 * @param $msg
	 * @param array $params
	 * @return int
	 */
	public function createVideo( array $videoData, &$msg, array $params = [] ) {

		$this->setVideoData( $videoData );
		if ( $this->shouldSkipVideo() ) {
			return 0;
		}
		$this->filterKeywords();
		$this->printInitialData();

		$remoteAsset = !empty( $params['remoteAsset'] );
		$addlCategories = empty( $params['addlCategories'] ) ? array() : $params['addlCategories'];

		$name = $this->generateName();
		$metadata = $this->generateMetadata( $msg );
		if ( !empty( $msg ) ) {
			$this->logger->videoWarnings( "Error when generating metadata.\n" );
			var_dump( $msg );
			return 0;
		}

		$provider = empty( $params['provider'] ) ? static::$PROVIDER : $params['provider'];

		// check if the video id exists in Ooyala.
		if ( $remoteAsset ) {
			$dupAssets = OoyalaAsset::getAssetsBySourceId( $this->videoData['videoId'], $provider );
			if ( !empty( $dupAssets ) ) {
				if ( $this->reupload === false ) {
					$this->logger->videoSkipped( "Skipping $name (Id: {$this->videoData['videoId']}, $provider) - video already exists in remote assets.\n" );
					return 0;
				}
			}
		}

		$duplicates = WikiaFileHelper::findVideoDuplicates( $provider, $this->videoData['videoId'], $remoteAsset );
		$dup_count = count( $duplicates );
		if ( $dup_count > 0 ) {
			if ( $this->reupload === false ) {
				// if reupload is disabled finish now
				$this->logger->videoSkipped( "Skipping $name (Id: {$this->videoData['videoId']}, $provider) - video already exists and reupload is disabled.\n" );
				return 0;
			}

			// if there are duplicates use name of one of them as reference
			// instead of generating new one
			$name = $duplicates[0]['img_name'];
			echo "Video already exists, using it's old name: $name\n";
		} else {
			// sanitize name
			$name = VideoFileUploader::sanitizeTitle( $name );
			// make sure the name is unique
			$name = $this->getUniqueName( $name );
		}
		$metadata['destinationTitle'] = $name;

		if ( !$this->validateTitle( $this->videoData['videoId'], $name, $msg ) ) {
			$this->logger->videoWarnings( "Error: $msg\n" );
			return 0;
		}

		// create category names to add to the new file page
		$categories = $this->generateCategories( $videoData, $addlCategories );

		// create remote asset (ooyala)
		if ( $remoteAsset ) {
			$metadata['pageCategories'] = implode( ', ', $categories );
			if ( !empty( $dupAssets ) ) {
				if ( !empty( $dupAssets[0]['metadata']['sourceid'] ) && $dupAssets[0]['metadata']['sourceid'] == $this->videoData['videoId'] ) {
					$result = $this->updateRemoteAsset( $this->videoData['videoId'], $name, $metadata, $dupAssets[0] );
				} else {
					$this->logger->videoSkipped( "Skipping {$metadata['name']} - {$metadata['description']}. SouceId not match (Id: {$this->videoData['videoId']}).\n" );
					return 0;
				}
			} else {
				$result = $this->createRemoteAsset( $this->videoData['videoId'], $name, $metadata );
			}

			return $result;
		}

		// prepare wiki categories string (eg [[Category:MyCategory]] )
		$categories[] = wfMessage( 'videohandler-category' )->inContentLanguage()->text();
		$categories = array_unique( $categories );
		$categoryStr = '';
		foreach ( $categories as $categoryName ) {
			$category = Category::newFromName( $categoryName );
			if ( $category instanceof Category ) {
				$categoryStr .= '[[' . $category->getTitle()->getFullText() . ']]';
			}
		}

		// prepare article body
		/** @var ApiWrapper $apiWrapper */
		$apiWrapper = new static::$API_WRAPPER( $this->videoData['videoId'], $metadata );

		// add category
		$body = $categoryStr."\n";

		// add description header
		$videoHandlerHelper = new VideoHandlerHelper();
		$body .= $videoHandlerHelper->addDescriptionHeader( $apiWrapper->getDescription() );

		if ( $this->debugMode() ) {
			print "Ready to create video\n";
			print "id:          {$this->videoData['videoId']}\n";
			print "name:        $name\n";
			print "categories:  " . implode( ',', $categories ) . "\n";
			print "metadata:\n";
			foreach ( explode( "\n", var_export( $metadata, 1 ) ) as $line ) {
				print ":: $line\n";
			}

			print "body:\n";
			foreach ( explode( "\n", $body ) as $line ) {
				print ":: $line\n";
			}

			$this->logger->videoIngested( "Ingested $name (id: {$this->videoData['videoData']}).\n", $categories );

			return 1;
		} else {
			/** @var Title $uploadedTitle */
			$uploadedTitle = null;
			$result = VideoFileUploader::uploadVideo( $provider, $this->videoData['videoId'], $uploadedTitle, $body, false, $metadata );
			if ( $result->ok ) {
				$fullUrl = WikiFactory::getLocalEnvURL( $uploadedTitle->getFullURL() );
				$this->logger->videoIngested( "Ingested {$uploadedTitle->getText()} from partner clip id {$this->videoData['videoId']}. {$fullUrl}\n", $categories );

				wfWaitForSlaves( self::THROTTLE_INTERVAL );
				wfRunHooks( 'VideoIngestionComplete', array( $uploadedTitle, $categories ) );
				return 1;
			}
		}

		$this->logger->videoWarnings();

		return 0;
	}

	/**
	 * Create remote asset
	 * @param string $id
	 * @param string $name
	 * @param array $metadata
	 * @return integer
	 */
	protected function createRemoteAsset( $id, $name, array $metadata ) {

		$assetData = $this->generateRemoteAssetData( $name, $metadata );
		if ( empty( $assetData['url']['flash'] ) ) {
			$this->logger->videoWarnings( "Error when generating remote asset data: empty asset url.\n" );
			return 0;
		}

		if ( empty( $assetData['duration'] ) || $assetData['duration'] < 0 ) {
			$this->logger->videoWarnings( "Error when generating remote asset data: invalid duration ($assetData[duration]).\n" );
			return 0;
		}

		// check if video title exists
		$ooyalaAsset = new OoyalaAsset();
		$isExist = $ooyalaAsset->isTitleExist( $assetData['assetTitle'], $assetData['provider'] );
		if ( $isExist ) {
			$this->logger->videoSkipped( "SKIP: Uploading Asset: $name ($assetData[provider]). Video already exists in remote assets.\n" );
			return 0;
		}

		if ( $this->debugMode() ) {
			print "Ready to create remote asset\n";
			print "id:          $id\n";
			print "name:        $name\n";
			print "assetdata:\n";
			foreach ( explode( "\n", var_export( $assetData, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			$result = $ooyalaAsset->addRemoteAsset( $assetData );
			if ( !$result ) {
				$this->logger->videoWarnings();
				return 0;
			}
		}

		$categories = empty( $metadata['pageCategories'] ) ? [] : explode( ", ", $metadata['pageCategories'] );
		$this->logger->videoIngested( "Uploaded remote asset: $name (id: $id)\n", $categories );

		return 1;
	}

	/**
	 * Update remote asset (metadata only)
	 * @param string $id
	 * @param string $name
	 * @param array $metadata
	 * @param array $dupAsset
	 * @return integer
	 */
	protected function updateRemoteAsset( $id, $name, array $metadata, $dupAsset ) {

		if ( empty( $dupAsset['embed_code'] ) ) {
			$this->logger->videoWarnings( "Error when updating remote asset data: empty asset embed code.\n" );
			return 0;
		}

		$assetData = $this->generateRemoteAssetData( $dupAsset['name'], $metadata, false );

		$ooyalaAsset = new OoyalaAsset();
		$assetMeta = $ooyalaAsset->getAssetMetadata( $assetData );

		// set reupload
		$assetMeta['reupload'] = 1;

		// remove unwanted data
		$emptyMetaKeys = array_diff( array_keys( $dupAsset['metadata'] ), array_keys( $assetMeta ) );
		foreach ( $emptyMetaKeys as $key ) {
			$assetMeta[$key] = null;
		}

		if ( $this->debugMode() ) {
			print "Ready to update remote asset\n";
			print "id:          $id\n";
			print "name:        $name\n";
			print "embed code:  $dupAsset[embed_code]\n";
			print "asset name:  $dupAsset[name]\n";
			print "metadata:\n";
			foreach ( explode( "\n", var_export( $assetMeta, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		} else {
			$result = OoyalaAsset::updateMetadata( $dupAsset['embed_code'], $assetMeta );
			if ( !$result ) {
				$this->logger->videoWarnings();
				return 0;
			}
		}

		$categories = empty( $metadata['pageCategories'] ) ? [] : explode( ", ", $metadata['pageCategories'] );
		$this->logger->videoIngested( "Uploaded remote asset: $name (id: $id)\n", $categories );

		return 1;
	}

	/**
	 * Generate remote asset data
	 * @param string $name
	 * @param array $data
	 * @return array $data
	 */
	protected function generateRemoteAssetData( $name, array $data ) {
		$data['assetTitle'] = $name;

		return $data;
	}

	/**
	 * @param $name
	 * @return string
	 */
	protected function getUniqueName( $name ) {
		$name_final = $name;
		$i = 2;
		// is this name available?
		$title = Title::newFromText( $name_final, NS_FILE );
		while ( $title && $title->exists() ) {
			$name_final = $name . ' ' . $i;
			$i++;
			$title = Title::newFromText( $name_final, NS_FILE );
		}
		return $name_final;
	}

	/**
	 * Returns whether the given video title has a value title object
	 * @param $videoId
	 * @param $name
	 * @param $msg
	 * @return bool
	 */
	protected function validateTitle( $videoId, $name, &$msg ) {

		$sanitizedName = VideoFileUploader::sanitizeTitle( $name );
		$title = Title::newFromText( $sanitizedName, NS_FILE );
		if ( is_null( $title ) ) {
			$msg = "article title was null: clip id $videoId. name: $name";
			return false;
		}
		return true;
	}

	/**
	 * @return array
	 */
	public function getWikiIngestionData() {

		$data = array();

		// merge data from datasource into a data structure keyed by
		// partner API search keywords. Value is an array of categories
		// relevant to wikis
		$rawData = $this->getWikiIngestionDataFromSource();
		foreach ( $rawData as $cityId => $cityData ) {
			if ( is_array( $cityData ) ) {
				foreach ( self::$WIKI_INGESTION_DATA_FIELDS as $field ) {
					if ( !empty( $cityData[$field] ) && is_array( $cityData[$field] ) ) {
						foreach ( $cityData[$field] as $fieldVal ) {
							if ( !empty( $data[$field][$fieldVal] ) && is_array( $data[$field][$fieldVal] ) ) {
								$data[$field][$fieldVal] = array_merge( $data[$field][$fieldVal], $cityData['categories'] );
							} else {
								$data[$field][$fieldVal] = $cityData['categories'];
							}
						}
					}
				}
			}
		}

		return $data;
	}

	/**
	 * @return array|bool|Object
	 */
	protected function getWikiIngestionDataFromSource() {
		global $wgExternalSharedDB, $wgMemc;

		$memcKey = wfMemcKey( self::CACHE_KEY );
		$aWikis = $wgMemc->get( $memcKey );
		if ( !empty( $aWikis ) ) {
			return $aWikis;
		}

		$aWikis = array();

		// fetch data from DB
		// note: as of 2011/11, this function is referred to by only one
		// calling function, a script that is run once per day. No need
		// to memcache result yet.
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$aTables = array(
			'city_variables',
			'city_variables_pool',
			'city_list',
		);
		$varName = mysql_real_escape_string( self::WIKI_INGESTION_DATA_VARNAME );
		$aWhere = array( 'city_id = cv_city_id', 'cv_id = cv_variable_id' );

		$aWhere[] = "cv_value is not null";

		$aWhere[] = "cv_name = '$varName'";


		$oRes = $dbr->select(
			$aTables,
			array( 'city_id', 'cv_value' ),
			$aWhere,
			__METHOD__,
			array( 'ORDER BY' => 'city_sitename' )
		);

		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			$aWikis[$oRow->city_id] = unserialize( $oRow->cv_value );
		}
		$dbr->freeResult( $oRes );

		$wgMemc->set( $memcKey, $aWikis, self::CACHE_EXPIRY );

		return $aWikis;
	}

	/**
	 * @param $url
	 * @param $options
	 * @return string
	 */
	protected function getUrlContent( $url, $options = array() ) {
		$options = array_merge( $options, $this->defaultRequestOptions );
		return Http::request( 'GET', $url, $options );
	}

	/**
	 * Try to find keyphrase in the subject. A keyphrase could be
	 * "harry potter". A keyphrase is present in the subject if "harry" and
	 * "potter" are present.
	 * @param string $subject
	 * @param string $keyphrase
	 * @return boolean
	 */
	protected function isKeyphraseInString( $subject, $keyphrase ) {
		$keyphraseFound = false;
		$keywords = explode( ' ', $keyphrase );
		$keywordMissing = false;
		foreach ( $keywords as $keyword ) {
			if ( stripos( $subject, $keyword ) === false ) {
				$keywordMissing = true;
				break;
			}
		}
		if ( !$keywordMissing ) {
			$keyphraseFound = true;
		}

		return $keyphraseFound;
	}

	/**
	 * Tests whether this video should be filtered out because of a string in its metadata.
	 *
	 * Set the $CLIP_FILTER static associative array in the child class to match a particular key or
	 * use '*' to match any key, e.g.:
	 *
	 *     $CLIP_FILTER = array( '*'        => '/Daily/',
	 *                           'keywords' => '/Adult/i',
	 *                         )
	 *
	 * This would filter out videos where any data contained the word 'Daily' and any video where the
	 * keywords contained the case insensitive string 'adult'
	 *
	 * @return bool - Returns true if the video should be filtered out, false otherwise
	 */
	protected function isFilteredVideo() {
		if ( is_array( static::$CLIP_FILTER ) ) {
			foreach ( $this->videoData as $key => $value ) {
				// See if we match key explicitly or by the catchall '*'
				$regex_list = empty( static::$CLIP_FILTER['*'] ) ? '' : static::$CLIP_FILTER['*'];
				$regex_list = empty( static::$CLIP_FILTER[$key] ) ? $regex_list : static::$CLIP_FILTER[$key];

				// If we don't have  regex at this point, skip this bit of clip data
				if ( empty( $regex_list ) ) {
					continue;
				}

				// This can be a single regex or a list of regexes
				$regex_list = is_array( $regex_list ) ? $regex_list : array( $regex_list );

				foreach ( $regex_list as $regex ) {
					if ( preg_match( $regex, $value ) ) {
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * get regex
	 * @param $keywords string with comma-separated keywords
	 * @return string regexp or null if no valid keywords were specified
	 */
	protected function getBlacklistRegex( $keywords ) {
		$regex = null;
		if ( $keywords ) {
			$keywords = explode( ',', $keywords );
			$blacklist = array();
			foreach ( $keywords as $word ) {
				$word = preg_replace( "/[^A-Za-z0-9' ]/", "", trim( $word ) );
				if ( $word ) {
					$blacklist[] = $word;
				}
			}

			if ( !empty( $blacklist ) ) {
				$regex = '/\b('.implode( '|', $blacklist ).')\b/i';
			}
		}

		return $regex;
	}

	/**
	 * check if video is blacklisted ( titleName, description, keywords, name )
	 * @return boolean
	 */
	public function isBlacklistedVideo() {

		// General filter on all keywords
		$regex = $this->getBlacklistRegex( F::app()->wg->VideoBlacklist );
		if ( !empty( $regex ) ) {
			$keys = array( 'titleName', 'description' );
			if ( array_key_exists( 'keywords', $this->videoData ) ) {
				$keys[] = 'keywords';
			}
			if ( array_key_exists( 'name', $this->videoData ) ) {
				$keys[] = 'name';
			}
			foreach ( $keys as $key ) {
				if ( preg_match( $regex, str_replace( '-', ' ', $this->videoData[$key] ) ) ) {
					echo "Blacklisting video: ".$this->videoData['titleName'].", videoId ".$this->videoData['videoId'].
						" (reason $key: ".$this->videoData[$key].")\n";
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * filter keywords from videoData
	 */
	protected function filterKeywords() {
		if ( !empty( $this->videoData['keywords'] ) ) {
			$regex = $this->getBlacklistRegex( F::app()->wg->VideoKeywordsBlacklist );
			$new = array();
			if ( !empty( $regex ) ) {
				$old = explode( ',', $this->videoData['keywords'] );
				foreach ( $old as $word ) {
					if ( preg_match( $regex, str_replace( '-', ' ', $word ) ) ) {
						echo "Skip: blacklisted keyword $word.\n";
						continue;
					}

					$new[] = $word;
				}
			}

			if ( !empty( $new ) ) {
				$this->videoData['keywords'] = implode( ',', $new );
			}
		}
	}

	/**
	 * Get normalized industry rating
	 * @param string $rating
	 * @return string
	 */
	public function getIndustryRating( $rating ) {
		return $this->dataNormalizer->getNormalizedIndustryRating( $rating );
	}

	/**
	 * Get age required from industry rating
	 * @param string $rating
	 * @return int
	 */
	public function getAgeRequired( $rating ) {
		return $this->dataNormalizer->getNormalizedAgeRequired( $rating );
	}

	/**
	 * get normalized category
	 * @param string $category
	 * @return string
	 */
	public function getCategory( $category ) {
		return $this->dataNormalizer->getNormalizedCategory( $category );
	}

	/**
	 * get normalized type
	 * @param string $type
	 * @return string
	 */
	public function getType( $type ) {
		return $this->dataNormalizer->getNormalizedType( $type );
	}

	/**
	 * get normalized genre
	 * @param string $genre
	 * @return string
	 */
	public function getGenre( $genre ) {
		return $this->dataNormalizer->getNormalizedGenre( $genre );
	}

	/**
	 * get normalized page category
	 * @param string $pageCategory
	 * @return string
	 */
	public function getPageCategory( $pageCategory ) {
		return $this->dataNormalizer->getNormalizedPageCategory( $pageCategory );
	}

	/**
	 * Get list of additional page category
	 * @param array $categories
	 * @return array $pageCategories
	 */
	public function getAdditionalPageCategories( array $categories ) {
		$pageCategories = array();
		foreach ( $categories as $category ) {
			$addition = $this->getAdditionalPageCategory( $category );
			if ( !empty( $addition ) ) {
				$pageCategories[] = $addition;
			}
		}

		return $pageCategories;
	}

	/**
	 * Get additional page category
	 * @param string $category
	 * @return string
	 */
	public function getAdditionalPageCategory( $category ) {
		return $this->dataNormalizer->getNormalizedAdditionalPageCategory( $category );
	}

	/**
	 * get CLDR code (return the original value if code not found)
	 * @param string $value
	 * @param string $type [language|country]
	 * @param boolean $code
	 * @return string $value
	 */
	public function getCLDRCode( $value, $type = 'language', $code = true ) {
		return $this->dataNormalizer->getCLDRCode( $value, $type, $code );
	}

	/**
	 * Get provider
	 * @return string
	 */
	public function getProvider() {
		return STATIC::$PROVIDER;
	}

}

