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
	const REMOTE_ASSET = false;

	protected static $API_WRAPPER;
	protected static $PROVIDER;
	protected static $FEED_URL;
	protected static $CLIP_FILTER = array();

	protected $defaultRequestOptions = [
		'noProxy' => true
	];

	private static $WIKI_INGESTION_DATA_FIELDS = array( 'keyphrases' );

	protected $dataNormalizer;
	protected $logger;
	protected $debug;
	protected $reupload;
	protected $oldName;
	protected $videoData;
	protected $metaData;

	public function __construct( array $params ) {
		$this->dataNormalizer = new IngesterDataNormalizer();
		$this->logger = new FeedIngesterLogger();
		$this->debug = !empty( $params['debug'] );
		$this->reupload = !empty( $params['reupload'] );
	}

	abstract public function import( $content = '', array $params = [] );

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $addlCategories - Any additional categories to add
	 * @return array - A list of category names
	 */
	abstract public function generateCategories( array $addlCategories );

	/**
	 * @param array $videoData
	 * @param array $addlCategories
	 * @return int
	 */
	public function createVideo( array $videoData, array $addlCategories = [] ) {

		$this->setVideoData( $videoData );
		try {
			$this->checkShouldSkipVideo();
			$this->printInitialData();
			$this->setMetaData( $addlCategories );
		} catch ( FeedIngesterSkippedException $e ) {
			$this->logger->videoSkipped( $e->getMessage() );
			return 0;
		} catch ( FeedIngesterWarningException $e ) {
			$this->logger->videoWarnings( $e->getMessage() );
			return 0;
		}

		return $this->saveVideo();
	}

	public function checkShouldSkipVideo() {
		$this->checkIsBlacklistedVideo();
		$this->checkIsFilteredVideo();
		$this->checkIsDuplicateVideo();
	}

	public function setVideoData( $videoData ) {
		$this->videoData = $videoData;
	}

	public function setMetaData( $addlCategories ) {
		$this->metaData = $this->generateMetadata( $addlCategories );
	}

	/**
	 * check if video is blacklisted ( titleName, description, keywords, name )
	 * @throws FeedIngesterSkippedException
	 */
	public function checkIsBlacklistedVideo() {

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
					$msg = "Skipping blacklisted video: {$this->videoData['titleName']}, videoId {$this->videoData['videoId']}";
					$msg .= " (reason $key: ".$this->videoData[$key].")\n";
					throw new FeedIngesterSkippedException( $msg );
				}
			}
		}
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
	 * @throws FeedIngesterSkippedException
	 */
	protected function checkIsFilteredVideo() {
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
						$msg = "Skipping (video is filtered) '{$this->videoData['titleName']}' - {$this->videoData['description']}.\n";
						throw new FeedIngesterSkippedException( $msg );
					}
				}
			}
		}
	}

	public function checkIsDuplicateVideo() {
		$this->checkVideoExistsOnWikia();
	}

	public function checkVideoExistsOnWikia() {
		$duplicates = WikiaFileHelper::findVideoDuplicates( $this->videoData['provider'], $this->videoData['videoId'], self::REMOTE_ASSET );
		if ( count( $duplicates ) > 0 ) {
			if ( !$this->reupload ) {
				$msg = "Skipping {$this->videoData['titleName']} (Id: {$this->videoData['videoId']}, $this->videoData['provider']) - video already exists and reupload is disabled.\n";
				throw new FeedIngesterSkippedException( $msg );
			}
			$this->oldName = $duplicates[0]['img_name'];
			echo "Video already exists, using it's old name: {$this->oldName}\n";
		} else {
			$this->oldName = null;
		}
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
	 * generate the metadata we consider interesting for this video
	 * Note: metadata is array instead of object because it's stored in the database as a serialized array,
	 *       and serialized objects would have more version issues.
	 * @param array $addlCategories
	 * @return array An associative array of metadata
	 * @throws FeedIngesterWarningException
	 */
	public function generateMetadata( $addlCategories ) {

		$this->filterKeywords( $this->videoData['keywords'] );
		$metaData = [
			'videoId'              => isset( $this->videoData['videoId'] ) ? $this->videoData['videoId'] : '',
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
			'destinationTitle'     => $this->getName(),
			'pageCategories'      => $this->generateCategories ( $addlCategories )
		];

		if ( empty( $metaData['videoId'] ) ) {
			$msg = "Warning: error when generating metadata -- no video id exists\n";
			throw new FeedIngesterWarningException( $msg );
		}

		if ( !$this->isValidDestinationTitle( $metaData['destinationTitle'] ) ) {
			$msg = "Warning: article title was null: clip id {$metaData['videoId']}. name: {$metaData['destinationTitle']}\n";
			throw new FeedIngesterWarningException( $msg );
		}

		return $metaData;
	}

	/**
	 * filter keywords from metaData
	 */
	protected function filterKeywords( &$keywords ) {
		if ( !empty( $keywords ) ) {
			$regex = $this->getBlacklistRegex( F::app()->wg->VideoKeywordsBlacklist );
			$new = array();
			if ( !empty( $regex ) ) {
				$old = explode( ',', $keywords );
				foreach ( $old as $word ) {
					if ( preg_match( $regex, str_replace( '-', ' ', $word ) ) ) {
						echo "Skip: blacklisted keyword $word.\n";
						continue;
					}

					$new[] = $word;
				}
			}

			if ( !empty( $new ) ) {
				$keywords = implode( ',', $new );
			}
		}
	}

	public function getName() {
		// Reuse name if duplicate video exists.
		if ( !is_null( $this->oldName ) ) {
			$name = $this->oldName;
		} else {
			$name = VideoFileUploader::sanitizeTitle( $this->generateName() );
			$name = $this->getUniqueName( $name );
		}

		return $name;
	}

	public function isValidDestinationTitle( $destinationTitle ) {
		$sanitizedName = VideoFileUploader::sanitizeTitle( $destinationTitle );
		$title = Title::newFromText( $sanitizedName, NS_FILE );
		if ( is_null( $title ) ) {
			return false;
		}
		return true;
	}

	public function saveVideo() {
		$categoryStr = $this->prepareCategoriesString();
		$body = $this->prepareBodyString( $categoryStr );
		if ( $this->debugMode() ) {
			$this->printReadyToSaveData( $body );
			$this->logger->videoIngested( "Ingested {$this->metaData['destinationTitle']} (id: {$this->metaData['videoId']}).\n", $this->metaData['pageCategories'] );
			return 1;
		} else {
			/** @var Title $uploadedTitle */
			$uploadedTitle = null;
			$result = VideoFileUploader::uploadVideo( $this->metaData['provider'], $this->metaData['videoId'], $uploadedTitle, $body, false, $this->metaData );
			if ( $result->ok ) {
				$fullUrl = WikiFactory::getLocalEnvURL( $uploadedTitle->getFullURL() );
				$this->logger->videoIngested( "Ingested {$uploadedTitle->getText()} from partner clip id {$this->metaData['videoId']}. {$fullUrl}\n", $this->metaData['pageCategories'] );

				wfWaitForSlaves( self::THROTTLE_INTERVAL );
				wfRunHooks( 'VideoIngestionComplete', array( $uploadedTitle, $this->metaData['pageCategories'] ) );
				return 1;
			}
		}

		$this->logger->videoWarnings();

		return 0;
	}

	// prepare wiki categories string (eg [[Category:MyCategory]] )
	public function prepareCategoriesString() {
		$this->metaData['pageCategories'][] = wfMessage( 'videohandler-category' )->inContentLanguage()->text();
		$this->metaData['pageCategories'] = array_unique( $this->metaData['pageCategories'] );
		$categoryStr = '';
		foreach ( $this->metaData['pageCategories'] as $categoryName ) {
			$category = Category::newFromName( $categoryName );
			if ( $category instanceof Category ) {
				$categoryStr .= '[[' . $category->getTitle()->getFullText() . ']]';
			}
		}

		return $categoryStr;
	}

	public function prepareBodyString( $categoryStr ) {
		/** @var ApiWrapper $apiWrapper */
		$apiWrapper = new static::$API_WRAPPER( $this->metaData['videoId'], $this->metaData );
		$videoHandlerHelper = new VideoHandlerHelper();
		$body = $categoryStr."\n";
		$body .= $videoHandlerHelper->addDescriptionHeader( $apiWrapper->getDescription() );
		return $body;
	}

	public function printReadyToSaveData( $body ) {
		print "Ready to create video\n";
		print "id:          {$this->metaData['videoId']}\n";
		print "name:        {$this->metaData['destinationTitle']}\n";
		print "categories:  " . implode( ',', $this->metaData['pageCategories'] ) . "\n";
		print "metadata:\n";
		foreach ( explode( "\n", var_export( $this->metaData, 1 ) ) as $line ) {
			print ":: $line\n";
		}

		print "body:\n";
		foreach ( explode( "\n", $body ) as $line ) {
			print ":: $line\n";
		}

	}

	/**
	 * Generate name for video.
	 * Note: The name is not sanitized for use as filename or article title.
	 * @return string video name
	 */
	protected function generateName() {
		return $this->videoData['titleName'];
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

	protected function debugMode() {
		return $this->debug;
	}

	public function getResultIngestedVideos() {
		return $this->logger->getResultIngestedVideos();
	}

	public function getResultSummary() {
		return $this->logger->getResultSummary();
	}
}

class FeedIngesterSkippedException extends Exception {}
class FeedIngesterWarningException extends Exception {}
