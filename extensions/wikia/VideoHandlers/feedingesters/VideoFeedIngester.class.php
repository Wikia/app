<?php

abstract class VideoFeedIngester {
	const PROVIDER_SCREENPLAY = 'screenplay';
	const PROVIDER_REALGRAVITY = 'realgravity';
	const PROVIDER_IGN = 'ign';
	const PROVIDER_ANYCLIP = 'anyclip';
	const PROVIDER_OOYALA = 'ooyala';
	public static $PROVIDERS = array(
		self::PROVIDER_SCREENPLAY,
		self::PROVIDER_IGN,
		self::PROVIDER_ANYCLIP,
		self::PROVIDER_REALGRAVITY,
		self::PROVIDER_OOYALA
	);
	public static $PROVIDERS_DEFAULT = array(
		self::PROVIDER_SCREENPLAY,
		self::PROVIDER_IGN,
		self::PROVIDER_ANYCLIP,
		self::PROVIDER_REALGRAVITY
	);
	protected static $API_WRAPPER;
	protected static $PROVIDER;
	protected static $FEED_URL;
	protected static $CLIP_TYPE_BLACKLIST = array();
	private static $instances = array();
	protected $filterByProviderVideoId = array();
	
	const CACHE_KEY = 'videofeedingester-2';
	const CACHE_EXPIRY = 3600;
	const THROTTLE_INTERVAL = 1;	// seconds

	const WIKI_INGESTION_DATA_VARNAME = 'wgPartnerVideoIngestionData';
	private static $WIKI_INGESTION_DATA_FIELDS = array('keyphrases');

	public $reupload = false;

	abstract public function import($content='', $params=array());
	/**
	 * Generate name for video.
	 * Note: The name is not sanitized for use as filename or article title.
	 * @param array $data video data
	 * @return string video name 
	 */
	abstract protected function generateName(array $data);
	abstract protected function generateMetadata(array $data, &$errorMsg);
	abstract protected function generateCategories(array $data, $addlCategories);

	/*
	 *  If  $this->filterByProviderVideoId  is not empty, the ingestion script will only upload the videos
	 *  that are in the array
	 */
	public function setFilter( $id ) {

		if ( !in_array( $id, $this->filterByProviderVideoId ) ) {
			$this->filterByProviderVideoId[] = $id;
		}
	}

	public static function getInstance($provider='') {
		if (empty($provider)) {
			$className = __CLASS__;
		}
		else {
			$className = ucfirst($provider) . 'FeedIngester';
			if (!class_exists($className)) {
				return null;
			}
		}
		
		if (empty(self::$instances[$className])) {
			self::$instances[$className] = new $className();
		}
		
		return self::$instances[$className];
	}

	public function createVideo(array $data, &$msg, $params=array()) {

		wfProfileIn( __METHOD__ );
		$debug = !empty($params['debug']);
		$ignoreRecent = !empty($params['ignorerecent']) ? $params['ignorerecent'] : 0;
		if($debug) {
			print "data after initial processing: \n";
			foreach( explode("\n", var_export($data, 1)) as $line ) {
				print ":: $line\n";
			}
		}
		$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();
		
		$id = $data['videoId'];
		$name = $this->generateName($data);
		$metadata = $this->generateMetadata($data, $msg);
		if (!empty($msg)) {
			print "Error when generating metadata\n";
			var_dump($msg);
			wfProfileOut( __METHOD__ );
			return 0;
		}

		$provider = empty($params['provider']) ? static::$PROVIDER : $params['provider'];

		$duplicates = WikiaFileHelper::findVideoDuplicates( $provider, $id );
		$dup_count = count($duplicates);
		$previousFile = null;
		if ( $dup_count > 0 ) {
			if ( $this->reupload === false ) {
				// if reupload is disabled finish now
				if($debug) {
					print "Not uploading - video already exists and reupload is disabled\n";
				}
				wfProfileOut( __METHOD__ );
				return 0;
			}

			// if there are duplicates use name of one of them as reference
			// instead of generating new one
			$name = $duplicates[0]['img_name'];
			echo "Video already exists, using it's old name: $name\n";
			$previousFile = Title::newFromText( $name, NS_FILE );
		} else {
			// sanitize name
			$name = VideoFileUploader::sanitizeTitle( $name );
			// make sure the name is unique
			$name = $this->getUniqueName( $name );
		}
		$metadata['destinationTitle'] = $name;

		if (!$this->validateTitle($id, $name, $msg, $debug)) {
			wfProfileOut( __METHOD__ );
			return 0;
		}

		// prepare wiki categories string (eg [[Category:MyCategory]] )
		$categories = $this->generateCategories($data, $addlCategories);
		$categories[] = wfMsgForContent( 'videohandler-category' );
		$categories = array_unique( $categories );
		$categoryStr = '';
		foreach ($categories as $categoryName) {
			$category = Category::newFromName($categoryName);
			if ($category instanceof Category) {
				$categoryStr .= '[[' . $category->getTitle()->getFullText() . ']]';
			}
		}

		// parepare article body
		$apiWrapper = new static::$API_WRAPPER($id, $metadata);
		$descriptionHeader = '==' . F::app()->wf->Msg('videohandler-description') . '==';
		$body = $categoryStr."\n".$descriptionHeader."\n".$apiWrapper->getDescription();

		if ($debug) {
			print "Ready to create video\n";
			print "id:          $id\n";
			print "name:        $name\n";
			print "categories:  " . implode(',', $categories) . "\n";
			print "metadata:\n";
			foreach(explode("\n",var_export($metadata,1)) as $line) {
				print ":: $line\n";
			}

			print "body:\n";
			foreach(explode("\n",$body) as $line) {
				print ":: $line\n";
			}

			wfProfileOut( __METHOD__ );
			return 1;
		}
		else {
			if(!empty($ignoreRecent) && !is_null($previousFile) ) {
				$revId = $previousFile->getLatestRevID();
				$revision = Revision::newFromId( $revId );
				$time = $revision->getTimestamp();
				$timeUnix = intval(wfTimestamp( TS_UNIX, $time ) );
				$timeNow = intval(wfTimestamp( TS_UNIX, time() ) );
				if($timeUnix + $ignoreRecent >= $timeNow) {
					print "Recently uploaded, ignoring\n";
					wfProfileOut( __METHOD__ );
					return 0;
				}
			}
			$uploadedTitle = null;
			$result = VideoFileUploader::uploadVideo( $provider, $id, $uploadedTitle, $body, false, $metadata );
			if ($result->ok) {
				$fullUrl = WikiFactory::getLocalEnvURL($uploadedTitle->getFullURL());
				print "Ingested {$uploadedTitle->getText()} from partner clip id $id. {$fullUrl}\n\n";
				wfWaitForSlaves(self::THROTTLE_INTERVAL);
				wfProfileOut( __METHOD__ );
				return 1;
			}
		}
		wfProfileOut( __METHOD__ );
		return 0;
	}

	protected function getUniqueName( $name ) {
		$name_final = $name;
		$i = 2;
		// is this name available?
		$title = Title::newFromText($name_final, NS_FILE);
		while ( $title && $title->exists() ) {
			$name_final = $name . ' ' . $i;
			$i++;
			$title = Title::newFromText($name_final, NS_FILE);
		}
		return $name_final;
	}
	
	protected function validateTitle($videoId, $name, &$msg, $isDebug) {

		wfProfileIn( __METHOD__ );
		$sanitizedName = VideoFileUploader::sanitizeTitle($name);
		$title = $this->titleFromText($sanitizedName);
		if(is_null($title)) {
			$msg = "article title was null: clip id $videoId. name: $name";
			wfProfileOut( __METHOD__ );
			return 0;
		}
		wfProfileOut( __METHOD__ );
		return 1;
	}

	protected function titleFromText($name) {
		return Title::newFromText($name, NS_FILE);
	}		
	
	public function getWikiIngestionData() {

		wfProfileIn( __METHOD__ );

		$data = array();
		
		// merge data from datasource into a data structure keyed by 
		// partner API search keywords. Value is an array of categories
		// relevant to wikis
		$rawData = $this->getWikiIngestionDataFromSource();
		foreach ($rawData as $cityId=>$cityData) {
			if (is_array($cityData)) {
				foreach (self::$WIKI_INGESTION_DATA_FIELDS as $field) {
					if (!empty($cityData[$field]) && is_array($cityData[$field])) {
						foreach ($cityData[$field] as $fieldVal) {
							if (!empty($data[$field][$fieldVal]) && is_array($data[$field][$fieldVal])) {
								$data[$field][$fieldVal] = array_merge($data[$field][$fieldVal], $cityData['categories']);
							}
							else {
								$data[$field][$fieldVal] = $cityData['categories'];
							}
						}
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $data;
	}

	protected function getWikiIngestionDataFromSource() {
		global $wgExternalSharedDB, $wgMemc;
		
		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey( self::CACHE_KEY );
		$aWikis = $wgMemc->get( $memcKey );
		if ( !empty( $aWikis ) ) {
			wfProfileOut( __METHOD__ );
			return $aWikis;
		}

		$aWikis = array();
		
		// fetch data from DB
		// note: as of 2011/11, this function is referred to by only one
		// calling function, a script that is run once per day. No need 
		// to memcache result yet.
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		
		$aTables = array(
			'city_variables',
			'city_variables_pool',
			'city_list',
		);
		$varName = mysql_real_escape_string(self::WIKI_INGESTION_DATA_VARNAME);
		$aWhere = array('city_id = cv_city_id', 'cv_id = cv_variable_id');
		
		$aWhere[] = "cv_value is not null";	
		
		$aWhere[] = "cv_name = '$varName'";


		$oRes = $dbr->select(
			$aTables,
			array('city_id', 'cv_value'),
			$aWhere,
			__METHOD__,
			array('ORDER BY' => 'city_sitename')
		);

		while ($oRow = $dbr->fetchObject($oRes)) {
			$aWikis[$oRow->city_id] = unserialize($oRow->cv_value);
		}
		$dbr->freeResult( $oRes );
		
		$wgMemc->set( $memcKey, $aWikis, self::CACHE_EXPIRY );
		wfProfileOut( __METHOD__ );

		return $aWikis;
	}

	protected function getUrlContent($url) {
		return Http::get($url);
	}
	
	/**
	 * Try to find keyphrase in the subject. A keyphrase could be 
	 * "harry potter". A keyphrase is present in the subject if "harry" and
	 * "potter" are present.
	 * @param string $subject
	 * @param string $keyphrase
	 * @return boolean 
	 */
	protected function isKeyphraseInString($subject, $keyphrase) {
		$keyphraseFound = false;
		$keywords = explode(' ', $keyphrase);
		$keywordMissing = false;
		foreach ($keywords as $keyword) {
			if (stripos($subject, $keyword) === false) {
				$keywordMissing = true;
				break;
			}
		}
		if (!$keywordMissing) {
			$keyphraseFound = true;
		}
		
		return $keyphraseFound;
	}

	protected function isClipTypeBlacklisted(array $clipData) {
		// assume that a clip with properties that match exactly undesired
		// values should not be imported. This assumption will have to
		// change if we consider values that fall into a range, such as
		// duration < MIN_VALUE
		if (is_array(static::$CLIP_TYPE_BLACKLIST)) {
			$arrayIntersect = array_intersect(static::$CLIP_TYPE_BLACKLIST, $clipData);
			if (!empty($arrayIntersect) && $arrayIntersect == static::$CLIP_TYPE_BLACKLIST) {
				return true;
			}
		}
		
		return false;
	}
	
}
