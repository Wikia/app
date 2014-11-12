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
	protected $filterByProviderVideoId = array();

	protected $defaultRequestOptions = [
		'noProxy' => true
	];

	private static $WIKI_INGESTION_DATA_FIELDS = array( 'keyphrases' );

	private $dataNormalizer;
	protected $debug;
	protected $reupload;
	protected $metaData;
	protected $duplicateAsset;

	public function __construct( array $params ) {
		$this->dataNormalizer = new IngesterDataNormalizer();
		$this->logger = new FeedIngesterLogger();
		$this->debug = !empty( $params['debug'] );
		$this->reupload = !empty( $params['reupload'] );
	}

	abstract public function import( $content = '', array $params = [] );

	/**
	 * Create a list of category names to add to the new file page
	 * @param $addlCategories - Any additional categories to add
	 * @return array - A list of category names
	 */
	abstract public function generateCategories( array $addlCategories );

	/**
	 * @param array $videoData
	 * @param array $params
	 * @return int
	 */
	public function createVideo( array $videoData, array $params = [] ) {

		$provider = empty( $params['provider'] ) ? static::$PROVIDER : $params['provider'];
		$addlCategories = empty( $params['addlCategories'] ) ? array() : $params['addlCategories'];

		try {
			$this->checkShouldSkipVideo( $videoData, $provider );
			$this->printInitialData( $videoData );
			$this->setMetaData( $videoData );
		} catch ( Exception $e ) {
			// TODO Figure out logging for screenPlayFeedIngester::generateMetadata
			return 0;
		}

		$categories = $this->generateCategories( $addlCategories );
		return $this->saveVideo( $categories, $provider );
	}

	public function checkShouldSkipVideo( $videoData, $provider ) {
		if ( $this->isBlacklistedVideo( $videoData )
			|| $this->isFilteredVideo( $videoData )
			|| ( $this->isDuplicateVideo( $videoData, $provider ) && !$this->reupload )
		) {
			throw new Exception();
		}
	}

	/**
	 * check if video is blacklisted ( titleName, description, keywords, name )
	 * @param array $videoData
	 * @return boolean
	 */
	public function isBlacklistedVideo( array $videoData ) {

		// General filter on all keywords
		$regex = $this->getBlacklistRegex( F::app()->wg->VideoBlacklist );
		if ( !empty( $regex ) ) {
			$keys = array( 'titleName', 'description' );
			if ( array_key_exists( 'keywords', $videoData ) ) {
				$keys[] = 'keywords';
			}
			if ( array_key_exists( 'name', $videoData ) ) {
				$keys[] = 'name';
			}
			foreach ( $keys as $key ) {
				if ( preg_match( $regex, str_replace( '-', ' ', $videoData[$key] ) ) ) {
					$this->logger->videoSkipped( "Skipping blacklisted video:".$videoData['titleName'].", videoId ".$videoData['videoId'].
						" (reason $key: ".$videoData[$key].")\n");
					return true;
				}
			}
		}
		return false;
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
	 * @param array $videoData
	 * @return bool - Returns true if the video should be filtered out, false otherwise
	 */
	protected function isFilteredVideo( $videoData ) {
		if ( is_array( static::$CLIP_FILTER ) ) {
			foreach ( $videoData as $key => $value ) {
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
						$this->logger->videoSkipped( "Skipping (video is filtered) '{$videoData['titleName']}' - {$videoData['description']}.\n" );
						return true;
					}
				}
			}
		}
		return false;
	}

	public function isDuplicateVideo( $videoData, $provider ) {
		return $this->videoExistsOnWikia( $videoData, $provider );
	}

	public function videoExistsOnWikia( $videoData, $provider ) {
		$duplicates = WikiaFileHelper::findVideoDuplicates( $provider, $videoData['videoId'], self::REMOTE_ASSET );
		if ( count( $duplicates ) > 0 ) {
			if ( !$this->reupload ) {
				// TODO make sure $this->metaData['videoTitle'] is accurate and works instead of $name
				$this->logger->videoSkipped( "Skipping {$videoData['titleName']} (Id: {$videoData['videoId']}, $provider) - video already exists and reupload is disabled.\n" );
			}
			// If there exists a duplicate video and we want to reupload the video, save that duplicate asset.
			// We'll use it later when determining the name to use for the video, and for remote asset saving.
			$this->duplicateAsset = $duplicates[0];
			return true;
		}
		return false;
	}

	public function printInitialData( $videoData ) {
		if ( $this->debugMode() ) {
			print "data after initial processing: \n";
			foreach ( explode( "\n", var_export( $videoData, 1 ) ) as $line ) {
				print ":: $line\n";
			}
		}
	}

	public function setMetaData( $videoData ) {
		$this->metaData = $this->generateMetadata( $videoData );
	}

	/**
	 * generate the metadata we consider interesting for this video
	 * Note: metadata is array instead of object because it's stored in the database as a serialized array,
	 *       and serialized objects would have more version issues.
	 * @param array $videoData
	 * @return array An associative array of metadata
	 * @throws VideoFeedIngesterException
	 */
	public function generateMetadata( $videoData ) {

		$this->filterKeywords();
		$metaData = [
			'videoId'              => isset( $videoData['videoId'] ) ? $videoData['videoId'] : '',
			'altVideoId'           => isset( $videoData['altVideoId'] ) ? $videoData['altVideoId'] : '',
			'hd'                   => isset( $videoData['hd'] ) ? $videoData['hd'] : 0,
			'duration'             => isset( $videoData['duration'] ) ? $videoData['duration'] : '',
			'published'            => isset( $videoData['published'] ) ? $videoData['published'] : '',
			'thumbnail'            => isset( $videoData['thumbnail'] ) ? $videoData['thumbnail'] : '',
			'description'          => isset( $videoData['description'] ) ? $videoData['description'] : '',
			'name'                 => isset( $videoData['name'] ) ? $videoData['name'] : '',
			'type'                 => isset( $videoData['type'] ) ? $videoData['type'] : '',
			'category'             => isset( $videoData['category'] ) ? $videoData['category'] : '',
			'keywords'             => isset( $videoData['keywords'] ) ? $videoData['keywords'] : '',
			'industryRating'       => isset( $videoData['industryRating'] ) ? $videoData['industryRating'] : '',
			'ageGate'              => isset( $videoData['ageGate'] ) ? $videoData['ageGate'] : 0,
			'ageRequired'          => isset( $videoData['ageRequired'] ) ? $videoData['ageRequired'] : 0,
			'provider'             => isset( $videoData['provider'] ) ? $videoData['provider'] : '',
			'language'             => isset( $videoData['language'] ) ? $videoData['language'] : '',
			'subtitle'             => isset( $videoData['subtitle'] ) ? $videoData['subtitle'] : '',
			'genres'               => isset( $videoData['genres'] ) ? $videoData['genres'] : '',
			'actors'               => isset( $videoData['actors'] ) ? $videoData['actors'] : '',
			'targetCountry'        => isset( $videoData['targetCountry'] ) ? $videoData['targetCountry'] : '',
			'series'               => isset( $videoData['series'] ) ? $videoData['series'] : '',
			'season'               => isset( $videoData['season'] ) ? $videoData['season'] : '',
			'episode'              => isset( $videoData['episode'] ) ? $videoData['episode'] : '',
			'characters'           => isset( $videoData['characters'] ) ? $videoData['characters'] : '',
			'resolution'           => isset( $videoData['resolution'] ) ? $videoData['resolution'] : '',
			'aspectRatio'          => isset( $videoData['aspectRatio'] ) ? $videoData['aspectRatio'] : '',
			'expirationDate'       => isset( $videoData['expirationDate'] ) ? $videoData['expirationDate'] : '',
			'regionalRestrictions' => isset( $videoData['regionalRestrictions'] ) ? $videoData['regionalRestrictions'] : '',
			'destinationTitle'     => $this->getName( $videoData )
		];

		if ( empty( $videoData['videoId'] ) ) {
			$this->logger->videoWarnings( "Warning: error when generating metadata -- no video id exists\n" );
			throw new VideoFeedIngesterException();
		}

		if ( !$this->isValidDestinationTitle( $metaData['destinationTitle'] ) ) {
			$this->logger->videoWarnings( "Warning: article title was null: clip id {$metaData['videoId']}. name: {$metaData['name']}\n" );
			throw new VideoFeedIngesterException();
		}

		return $metaData;
	}

	/**
	 * filter keywords from metaData
	 */
	protected function filterKeywords() {
		if ( !empty( $this->metaData['keywords'] ) ) {
			$regex = $this->getBlacklistRegex( F::app()->wg->VideoKeywordsBlacklist );
			$new = array();
			if ( !empty( $regex ) ) {
				$old = explode( ',', $this->metaData['keywords'] );
				foreach ( $old as $word ) {
					if ( preg_match( $regex, str_replace( '-', ' ', $word ) ) ) {
						echo "Skip: blacklisted keyword $word.\n";
						continue;
					}

					$new[] = $word;
				}
			}

			if ( !empty( $new ) ) {
				$this->metaData['keywords'] = implode( ',', $new );
			}
		}
	}

	public function getName( $videoData ) {
		// Reuse name if duplicate video exists.
		if ( !is_null( $this->duplicateAsset ) ) {
			$name = $this->duplicateAsset['img_name'];
		} else {
			$name = VideoFileUploader::sanitizeTitle( $this->generateName( $videoData ) );
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

	public function saveVideo( $categories, $provider ) {
		$categoryStr = $this->prepareCategoriesString( $categories );
		$body = $this->prepareBodyString( $categoryStr );
		if ( $this->debugMode() ) {
			$this->printReadyToSaveData( $body, $categories );
			$this->logger->videoIngested( "Ingested {$this->metaData['destinationTitle']} (id: {$this->metaData['videoId']}).\n", $categories );
			return 1;
		} else {
			/** @var Title $uploadedTitle */
			$uploadedTitle = null;
			$result = VideoFileUploader::uploadVideo( $provider, $this->metaData['videoId'], $uploadedTitle, $body, false, $this->metaData );
			if ( $result->ok ) {
				$fullUrl = WikiFactory::getLocalEnvURL( $uploadedTitle->getFullURL() );
				$this->logger->videoIngested( "Ingested {$uploadedTitle->getText()} from partner clip id {$this->metaData['videoId']}. {$fullUrl}\n", $categories );

				wfWaitForSlaves( self::THROTTLE_INTERVAL );
				wfRunHooks( 'VideoIngestionComplete', array( $uploadedTitle, $categories ) );
				return 1;
			}
		}

		$this->logger->videoWarnings();

		return 0;
	}

	// prepare wiki categories string (eg [[Category:MyCategory]] )
	public function prepareCategoriesString( $categories ) {
		$categories[] = wfMessage( 'videohandler-category' )->inContentLanguage()->text();
		$categories = array_unique( $categories );
		$categoryStr = '';
		foreach ( $categories as $categoryName ) {
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

	public function printReadyToSaveData( $body, $categories ) {
		print "Ready to create video\n";
		print "id:          {$this->metaData['videoId']}\n";
		print "name:        {$this->metaData['destinationTitle']}\n";
		print "categories:  " . implode( ',', $categories ) . "\n";
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
	 * @param array $videoData
	 * @return string video name
	 */
	protected function generateName( array $videoData ) {
		return $videoData['titleName'];
	}

	/**
	 *  If  $this->filterByProviderVideoId is not empty, the ingestion script will only upload the videos
	 *  that are in the array
	 * @param $id
	 */
	public function setFilter( $id ) {

		if ( !in_array( $id, $this->filterByProviderVideoId ) ) {
			$this->filterByProviderVideoId[] = $id;
		}
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

class VideoFeedIngesterException extends Exception {}