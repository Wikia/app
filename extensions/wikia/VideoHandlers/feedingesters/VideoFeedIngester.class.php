<?php

/**
 * Class VideoFeedIngester
 */
abstract class VideoFeedIngester {

	// Caching constants; all integers are seconds
	const CACHE_KEY = 'videofeedingester-2';
	const CACHE_EXPIRY = 3600;

	// Names a city variable to look for additional category data.  Used in the reingestBrokenVideo.php
	const WIKI_INGESTION_DATA_VARNAME = 'wgPartnerVideoIngestionData';
	public static $REMOTE_ASSET = false;

	protected static $API_WRAPPER;
	protected static $PROVIDER;
	protected static $FEED_URL;
	protected static $CLIP_FILTER = [];

	protected $defaultRequestOptions = [
		'noProxy' => true
	];

	private static $WIKI_INGESTION_DATA_FIELDS = [ 'keyphrases' ];

	public $videoData;
	public $metaData;
	public $oldName;

	protected $dataNormalizer;
	protected $logger;
	protected $debug;
	protected $reupload;
	protected $pageCategories;

	public function __construct( array $params = [] ) {
		$this->dataNormalizer = new FeedIngesterDataNormalizer();
		$this->logger = new FeedIngesterLogger();
		$this->debug = !empty( $params['debug'] );
		$this->reupload = !empty( $params['reupload'] );
	}

	/**
	 * Implemented by each subclass to handle contacting each provider's
	 * API and preparing that data to be passed to createVideo.
	 * @param string $content
	 * @param array $params
	 * @return mixed
	 */
	abstract public function import( $content = '', array $params = [] );

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $addlCategories - Any additional categories to add
	 * @return array - A list of category names
	 */
	abstract public function generateCategories( array $addlCategories );

	/**
	 * During ingestion, each subclass implements it's own import method
	 * which contacts the provider's API, marshals data, and finally passes
	 * that data along with any additional categories we want added to the
	 * page to this createVideo method. createVideo takes care of checking if we
	 * should skip that video for any reason, preparing that videoData into
	 * a more general metaData array which includes stubs for all fields we
	 * want saved for a given video, and finally saving that video either onto
	 * Wikia or Ooyala. See RemoteAssetFeedIngester for more info on that
	 * distinction.
	 * @param array $videoData
	 * @param array $addlCategories
	 * @return int
	 */
	public function createVideo( array $videoData, array $addlCategories = [] ) {

		$this->setVideoData( $videoData );
		try {
			$this->checkShouldSkipVideo();
			$this->printInitialData();
			$this->setMetaData();
		} catch ( FeedIngesterSkippedException $e ) {
			$this->logger->videoSkipped( $e->getMessage() );
			return 0;
		} catch ( FeedIngesterWarningException $e ) {
			$this->logger->videoWarnings( $e->getMessage() );
			return 0;
		}

		$this->setPageCategories( $addlCategories );
		return $this->saveVideo();
	}

	/**
	 * Set the videoData passed in by a subclass into createVideo() as a member variable.
	 * Makes it easier to validate and work with as we prepare that data to be put into
	 * the more generalize metaData array.
	 * @param $videoData
	 */
	public function setVideoData( $videoData ) {
		$this->videoData = $videoData;
	}

	/**
	 * Check if we should skip the video.
	 */
	public function checkShouldSkipVideo() {
		$this->checkIsBlacklistedVideo();
		$this->checkIsFilteredVideo();
		$this->checkIsDuplicateVideo();
	}

	/**
	 * check if video is blacklisted ( titleName, description, keywords, name )
	 * @throws FeedIngesterSkippedException
	 */
	public function checkIsBlacklistedVideo() {

		// General filter on all keywords
		$regex = $this->getBlacklistRegex( F::app()->wg->VideoBlacklist );
		if ( !empty( $regex ) ) {
			$keys = [ 'titleName', 'description' ];
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
	 *     $CLIP_FILTER = [ '*'        => '/Daily/',
	 *                     'keywords' => '/Adult/i',
	 *                    ]
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
				$regexList = empty( static::$CLIP_FILTER['*'] ) ? '' : static::$CLIP_FILTER['*'];
				$regexList = empty( static::$CLIP_FILTER[$key] ) ? $regexList : static::$CLIP_FILTER[$key];

				// If we don't have  regex at this point, skip this bit of clip data
				if ( empty( $regexList ) ) {
					continue;
				}

				// This can be a single regex or a list of regexes
				$regexList = is_array( $regexList ) ? $regexList : [ $regexList ];

				foreach ( $regexList as $regex ) {
					if ( preg_match( $regex, $value ) ) {
						$msg = "Skipping (video is filtered) '{$this->videoData['titleName']}' - {$this->videoData['description']}.\n";
						throw new FeedIngesterSkippedException( $msg );
					}
				}
			}
		}
	}

	/**
	 * Checks if the video is a duplicate. This is overridden by RemoteAssettFeedIngester
	 * which checks both if the video exists on Wikia, but also if it exists on Ooyala.
	 */
	public function checkIsDuplicateVideo() {
		$this->checkVideoExistsOnWikia();
	}

	/**
	 * Checks if a the video already exists on Wikia. If so, and reupload is on, save the name of that
	 * video in $this->oldName. This will be used later in the ingestion process.
	 * @throws FeedIngesterSkippedException
	 */
	public function checkVideoExistsOnWikia() {
		$duplicates = WikiaFileHelper::findVideoDuplicates( $this->videoData['provider'], $this->videoData['videoId'], static::$REMOTE_ASSET );
		if ( count( $duplicates ) > 0 ) {
			$oldName = $duplicates[0]['img_name'];
			if ( !$this->reupload ) {
				$msg = "Skipping $oldName (Id: {$this->videoData['videoId']}, {$this->videoData['provider']}) - ";
				$msg .= "video already exists on Wikia and reupload is disabled.\n";
				throw new FeedIngesterSkippedException( $msg );
			}
			$this->oldName = $oldName;
			echo "Video already exists, using it's old name: {$this->oldName}\n";
		} else {
			$this->oldName = null;
		}
	}

	/**
	 * Print the videoData that was passed into createVideo(). This is the video
	 * metadata prepared by each subclass during its ingestion. This videoData will
	 * be used to populate the more general metaData array which includes all fields
	 * we want saved for a video.
	 */
	public function printInitialData() {
		if ( $this->debugMode() ) {
			print "data after initial processing: \n";
			foreach ( explode( "\n", var_export( $this->videoData, 1 ) ) as $line ) {
				print ":: $line\n";
			}
		}
	}

	/**
	 * set metaData, the generalized array which we'll use when actually saving the video,
	 * as a member variable. Uses the generateMetadata method which marshals a base set of
	 * information we want for each video, which is then overridden by subclasses to add
	 * metadata which is specific to that provider.
	 */
	public function setMetaData() {
		$this->metaData = $this->generateMetadata();
	}

	/**
	 * generate the metadata we consider interesting for this video. This comes from videoData which was passed
	 * in by each subclass during the ingestion process to createVideo.
	 * Note: metadata is array instead of object because it's stored in the database as a serialized array,
	 *       and serialized objects would have more version issues.
	 * @throws FeedIngesterWarningException
	 * @return array An associative array of metadata
	 */
	public function generateMetadata() {

		// Default keys we want to check for. If a key from $valueOrEmptyString can't be found in $this->videoData
		// set it's value to '' in metaData. Same for $valueOrZero but set it's value to 0 in metaData instead.
		$valueOrEmptyString = [
			'videoId', 'altVideoId', 'duration', 'published', 'thumbnail', 'description', 'name', 'type', 'category',
			'industryRating', 'provider', 'language', 'subtitle', 'genres', 'actors', 'targetCountry', 'series',
			'season', 'episode', 'characters', 'resolution', 'aspectRatio', 'expirationDate', 'regionalRestrictions'
		];
		$valueOrZero = [ 'hd', 'ageRequired', 'ageGate' ];

		$metaData = [];
		foreach( $valueOrEmptyString as $key ) {
			$metaData[$key] = $this->getVideoData( $key );
		}
		foreach ( $valueOrZero as $key ) {
			$metaData[$key] = $this->getVideoData( $key, 0 );
		}
		$metaData['keywords'] = $this->filterKeywords();
		$metaData['destinationTitle'] = $this->getName();

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
	 * Get value of $this->videoData[$key] if it's set, otherwise return $default.
	 * @param $key
	 * @param $default
	 * @return mixed
	 */
	protected function getVideoData( $key, $default = '' ) {
		return isset( $this->videoData[$key] ) ? $this->videoData[$key] : $default;
	}

	/**
	 * filter keywords from metaData
	 */
	protected function filterKeywords() {
		$filteredKeyWords = '';
		if ( !empty( $this->videoData['keywords'] ) ) {
			$regex = $this->getBlacklistRegex( F::app()->wg->VideoKeywordsBlacklist );
			$new = [];
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
				$filteredKeyWords = implode( ',', $new );
			}
		}
		return $filteredKeyWords;
	}

	/**
	 * Get the name we should use for this video. If $this->oldName exists,
	 * we know that a duplicate of that video was found and reupload is on
	 * so we should reuse that name. Otherwise, create a new unique name.
	 * @return string
	 */
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

	/**
	 * Return if the title we plan on using to create the video is valid.
	 * @param $destinationTitle
	 * @return bool
	 */
	public function isValidDestinationTitle( $destinationTitle ) {
		$sanitizedName = VideoFileUploader::sanitizeTitle( $destinationTitle );
		$title = Title::newFromText( $sanitizedName, NS_FILE );
		return !is_null( $title );
	}

	/**
	 * Set the page categories we want added to the video's file page into
	 * a member variable.
	 * @param array $addlCategories
	 */
	public function setPageCategories( array $addlCategories =[] ) {
		$this->pageCategories = $this->generateCategories( $addlCategories );
	}

	/**
	 * After all the video meta data and categories have been prepared, upload the video
	 * onto Wikia.
	 * @return int
	 */
	public function saveVideo() {
		$body = $this->prepareBodyString();
		if ( $this->debugMode() ) {
			$this->printReadyToSaveData( $body );
			$msg = "Ingested {$this->metaData['destinationTitle']} (id: {$this->metaData['videoId']}).\n";
			$this->logger->videoIngested( $msg, $this->pageCategories );
			return 1;
		} else {
			/** @var Title $uploadedTitle */
			$uploadedTitle = null;
			$result = VideoFileUploader::uploadVideo( $this->metaData['provider'], $this->metaData['videoId'], $uploadedTitle, $body, false, $this->metaData );
			if ( $result->ok ) {
				$fullUrl = WikiFactory::getLocalEnvURL( $uploadedTitle->getFullURL() );
				$msg = "Ingested {$uploadedTitle->getText()} from partner clip id {$this->metaData['videoId']}. $fullUrl\n";
				$this->logger->videoIngested( $msg, $this->pageCategories );

				wfWaitForSlaves();
				wfRunHooks( 'VideoIngestionComplete', [ $uploadedTitle, $this->pageCategories ] );
				return 1;
			}
		}

		$this->logger->videoWarnings();

		return 0;
	}

	/**
	 * Prepare the string used for the article content of the file page. This includes
	 * the category string string and description. eg:
	 *
	 * [[Category:Phantasy Star Nova]][[Category:IGN]][[Category:IGN games]][[Category:Games]][[Category:Videos]]
	 *  ==Description==
	 * Check out the character creator mode as well as the battle system in this PlayStation Vita exclusive.
	 *
	 * @return string
	 */
	public function prepareBodyString() {
		/** @var ApiWrapper $apiWrapper */
		$apiWrapper = new static::$API_WRAPPER( $this->metaData['videoId'], $this->metaData );
		$videoHandlerHelper = new VideoHandlerHelper();
		$body = $this->prepareCategoriesString();
		$body .= $videoHandlerHelper->addDescriptionHeader( $apiWrapper->getDescription() );
		return $body;
	}

	/**
	 * Prepare wiki categories string (eg [[Category:MyCategory]] )
	 * @return string
	 */
	public function prepareCategoriesString() {
		$this->pageCategories[] = wfMessage( 'videohandler-category' )->inContentLanguage()->text();
		$this->pageCategories = array_unique( $this->pageCategories );
		$categoryStr = '';
		foreach ( $this->pageCategories as $categoryName ) {
			$category = Category::newFromName( $categoryName );
			if ( $category instanceof Category ) {
				$categoryStr .= '[[' . $category->getTitle()->getFullText() . ']]';
			}
		}

		return $categoryStr . "\n";
	}

	/**
	 * Print the video meta data and categories that would be saved. Used in
	 * debug mode.
	 * @param $body
	 */
	public function printReadyToSaveData( $body ) {
		print "Ready to create video\n";
		print "id:          {$this->metaData['videoId']}\n";
		print "name:        {$this->metaData['destinationTitle']}\n";
		print "categories:  " . implode( ',', $this->pageCategories ) . "\n";
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
		$nameFinal = $name;
		$i = 2;
		// is this name available?
		$title = Title::newFromText( $nameFinal, NS_FILE );
		while ( $title && $title->exists() ) {
			$nameFinal = $name . ' ' . $i;
			$i++;
			$title = Title::newFromText( $nameFinal, NS_FILE );
		}
		return $nameFinal;
	}

	/**
	 * @return array
	 */
	public function getWikiIngestionData() {

		$data = [];

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

		$aWikis = [];

		// fetch data from DB
		// note: as of 2011/11, this function is referred to by only one
		// calling function, a script that is run once per day. No need
		// to memcache result yet.
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$aTables = [
			'city_variables',
			'city_variables_pool',
			'city_list',
		];
		$aWhere = [ 'city_id = cv_city_id', 'cv_id = cv_variable_id' ];

		$aWhere[] = "cv_value is not null";

		$aWhere['cv_name'] = self::WIKI_INGESTION_DATA_VARNAME;


		$oRes = $dbr->select(
			$aTables,
			[ 'city_id', 'cv_value' ],
			$aWhere,
			__METHOD__,
			[ 'ORDER BY' => 'city_sitename' ]
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
	protected function getUrlContent( $url, $options = [] ) {
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
			$blacklist = [];
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
		$pageCategories = [];
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
	 * Returns if run in debug mode.
	 * @return bool
	 */
	protected function debugMode() {
		return $this->debug;
	}

	/**
	 * Returns the results of the ingestion, broken down by category of videos
	 * ingested. Returns an array with a count for the following categories:
	 * Games, Entertainment, Lifestyle, International, and Other
	 * @return array
	 */
	public function getResultIngestedVideos() {
		return $this->logger->getResultIngestedVideos();
	}

	/**
	 * Returns the results of the ingestion. This is an array which reports the
	 * number of found, ingested, and skipped videos, as well as the number of
	 * warnings or errors encountered.
	 * @return array
	 */
	public function getResultSummary() {
		return $this->logger->getResultSummary();
	}
}

class FeedIngesterSkippedException extends Exception {}
class FeedIngesterWarningException extends Exception {}
