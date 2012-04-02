<?php

class PartnerVideoHelper {

	private static $SCREENPLAY_FEED_URL = 'https://secure.totaleclips.com/WebServices/GetDataFeed.aspx?customerId=$1&username=$2&password=$3&startDate=$4&endDate=$5';
	private static $MOVIECLIPS_VIDEOS_LISTING_FOR_MOVIE_URL = 'http://api.movieclips.com/v2/movies/$1/videos';
	private static $MOVIECLIPS_XMLNS = 'http://api.movieclips.com/schemas/2010';
	private static $MOVIECLIPS_API_REQUEST_DELAY = 2;	// seconds
	private static $REALGRAVITY_API_KEY = '4bd3e310-9c30-012e-b52b-12313d017962';
	private static $REALGRAVITY_PROVIDER_IDS = array('MACHINIMA'=>240);
	private static $REALGRAVITY_PAGE_SIZE = 100;
	private static $REALGRAVITY_VIDEOS_URL = 'http://mediacast.realgravity.com/vs/2/videos/$1.xml?providers=$2&lookup_columns=tag_list,title&search_term=$3&per_page=$4&page=$5';
	private static $REALGRAVITY_DIMENSIONS = '512x288';
	private static $TEMP_DIR = '/tmp';
	
	private static $CLIP_TYPE_BLACKLIST = array( VideoPage::V_SCREENPLAY => array() );
	
	private static $PARTNER_VIDEO_INGESTION_DATA_VARNAME = 'wgPartnerVideoIngestionData';
	private static $PARTNER_VIDEO_INGEESTION_DATA_FIELDS = array('keyphrases', 'movieclipsIds');
	
	const THROTTLE_INTERVAL = 1;	// seconds
	
	protected static $instance;
	
	const CACHE_KEY = 'partnervideoingestion';
	const CACHE_EXPIRY = 3600;

	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new PartnerVideoHelper();
		}

		return self::$instance;
	}
	
	private static function initScreenplayFeedUrl($startDate, $endDate) {
		global $remoteUser, $remotePassword, $wgScreenplayApiConfig;
		
		$url = str_replace('$1', $wgScreenplayApiConfig['customerId'], self::$SCREENPLAY_FEED_URL );
		$url = str_replace('$2', $remoteUser, $url);
		$url = str_replace('$3', $remotePassword, $url);
		$url = str_replace('$4', $startDate, $url);
		$url = str_replace('$5', $endDate, $url);
		return $url;
	}


	public function downloadScreenplayFeed($startDate, $endDate) {
		global $remoteUser, $remotePassword, $parseOnly;

		$url = self::initScreenplayFeedUrl($startDate, $endDate);

		$info = array();
		!$parseOnly && print("Connecting to $url...\n");

		$xmlContent = $this->getUrlContent($url);

		if (!$xmlContent) {
			print("ERROR: problem downloading content!\n");
			return 0;
		}

		return $xmlContent;	
	}

	public function importFromPartner($provider, $file, $params=array()) {
		global $parseOnly, $addlCategories;
		
		$numCreated = 0;

		switch ($provider) {
			case VideoPage::V_SCREENPLAY:
				$numCreated = $this->importFromScreenplay($file, $params);
				break;
			case VideoPage::V_MOVIECLIPS:
				if (!empty($params['movieclipsidsCategories'])) {
					foreach ($params['movieclipsidsCategories'] as $id=>$categories) {
						$addlCategories = $categories;
						$numCreated += $this->importFromMovieClips($id);
					}
				}
				else {
					$ids = self::getApiQueryTermsFromFileContents($file);					
					foreach ($ids as $id) {
						$numCreated += $this->importFromMovieClips($id);
					}
				}
				break;
			case VideoPage::V_REALGRAVITY:
				if (!empty($params['keyphrasesCategories'])) {
					foreach ($params['keyphrasesCategories'] as $keyphrase=>$categories) {
						$addlCategories = $categories;
						$numCreated += $this->importFromRealgravity($keyphrase);
					}
				}
				else {
					$keywords = self::getApiQueryTermsFromFileContents($file);
					foreach ($keywords as $keyword) {
						$numCreated += $this->importFromRealgravity($keyword);
					}					
				}
				break;
			default:
		}

		!$parseOnly && print "Created $numCreated articles!\n\n";
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
	
	public function importFromScreenplay($file, $params=array()) {
		global $parseOnly, $debug, $addlCategories;

		$articlesCreated = 0;

		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $file );
		$titles = $doc->getElementsByTagName('Title');
		$numTitles = $titles->length;
		!$parseOnly && print("Found $numTitles titles...\n");
		for ($i=0; $i<$numTitles; $i++) {
			$title = $titles->item($i);
			$titleName = html_entity_decode( $title->getElementsByTagName('TitleName')->item(0)->textContent );

			if (!empty($params['keyphrasesCategories'])) {
				$addlCategories = array();
				foreach ($params['keyphrasesCategories'] as $keyphrase=>$categories) {
					if ($this->isKeyphraseInString($titleName, $keyphrase)) {
						$addlCategories = array_merge($addlCategories, $categories);
					}		
				}
				if (empty($addlCategories)) {
					// keep going. If this title has Movie Trailer clips, ingest them
				}
			}
			
			$year = $title->getElementsByTagName('Year')->item(0)->textContent;
			$clips = $title->getElementsByTagName('Clip');
			$numClips = $clips->length;
			$origAddlCategories = $addlCategories;
			for ($j=0; $j<$numClips; $j++) {
				$addlCategories = $origAddlCategories;
				$clipData = array('titleName'=>$titleName, 'year'=>$year);

				$clip = $clips->item($j);
				$clipData['trailerType'] = $clip->getElementsByTagName('TrailerType')->item(0)->textContent;
				$clipData['trailerVersion'] = $clip->getElementsByTagName('TrailerVersion')->item(0)->textContent;
				if (empty($addlCategories)) {
					if (strtolower($clipData['trailerVersion']) == 'trailer'
					&& (strtolower($clipData['trailerType']) != 'video game' && stripos($clipData['titleName'], '(VG)') === false)
					) {
						$addlCategories[] = 'Movie Trailers';
					}
				}
				if (strtolower($clipData['trailerType']) == 'not set') unset($clipData['trailerType']);
				if (strtolower($clipData['trailerVersion']) == 'not set') unset($clipData['trailerVersion']);
				$clipData['eclipId'] = $clip->getElementsByTagName('EclipId')->item(0)->textContent;
				$clipData['description'] = html_entity_decode( $clip->getElementsByTagName('Description')->item(0)->textContent );
				$clipData['duration'] = $clip->getElementsByTagName('RunTime')->item(0)->textContent;
				$clipData['jpegBitrateCode'] = VideoPage::SCREENPLAY_MEDIUM_JPEG_BITRATE_ID;

				$encodes = $clip->getElementsByTagName('Encode');
				$numEncodes = $encodes->length;
				for ($k=0; $k<$numEncodes; $k++) {				
					$encode = $encodes->item($k);
					$url = html_entity_decode( $encode->getElementsByTagName('Url')->item(0)->textContent );					
					$bitrateCode = $encode->getElementsByTagName('EncodeBitRateCode')->item(0)->textContent;
					$formatCode = $encode->getElementsByTagName('EncodeFormatCode')->item(0)->textContent;
					switch ($formatCode) {
						case VideoPage::SCREENPLAY_ENCODEFORMATCODE_JPEG:
							switch ($bitrateCode) {
								case VideoPage::SCREENPLAY_LARGE_JPEG_BITRATE_ID:
									$clipData['jpegBitrateCode'] = VideoPage::SCREENPLAY_LARGE_JPEG_BITRATE_ID;
									break;
								case VideoPage::SCREENPLAY_MEDIUM_JPEG_BITRATE_ID:
								default:
							}
							break;
						case VideoPage::SCREENPLAY_ENCODEFORMATCODE_MP4:
							switch ($bitrateCode) {
								case VideoPage::SCREENPLAY_STANDARD_BITRATE_ID:
								case VideoPage::SCREENPLAY_STANDARD_43_BITRATE_ID:
									$clipData['stdBitrateCode'] = $bitrateCode;
									$clipData['stdMp4Url'] = $url;
									break;
								case VideoPage::SCREENPLAY_HIGHDEF_BITRATE_ID:
									$clipData['hdMp4Url'] = $url;
									break;
								default:
							}
							break;
						default:
					}
				}

				$msg = '';
				if ($this->isClipTypeBlacklisted(VideoPage::V_SCREENPLAY, $clipData)) {
					if ($debug) {
						print "Skipping {$clipData['titleName']} ({$clipData['year']}) - {$clipData['description']}. On clip type blacklist\n";
					}
				}
				else {
					$articlesCreated += $this->createVideoPageForPartnerVideo(VideoPage::V_SCREENPLAY, $clipData, $msg);
				}
				if ($msg) {
					print "ERROR: $msg\n";
				}
			}
		}

		return $articlesCreated;
	}

	public function importFromMovieClips($id) {
		global $parseOnly;

		$articlesCreated = 0;

		$url = str_replace('$1', $id, self::$MOVIECLIPS_VIDEOS_LISTING_FOR_MOVIE_URL);
		$info = array();
		!$parseOnly && print("Connecting to $url...\n");

		sleep(self::$MOVIECLIPS_API_REQUEST_DELAY);	// making too many requests results in 503 errors
		$rssContent = $this->getUrlContent($url);
		
		if (!$rssContent) {
			print("ERROR: problem downloading content!\n");
			return 0;
		}

		$feed = new SimplePie();
		$feed->set_raw_data($rssContent);
		$feed->init();
		if ($feed->error()) {
			print("ERROR: {$feed->error()}");
			return $articlesCreated;
		}

		foreach ($feed->get_items() as $key=>$item) {
			// video title
			$clipData['clipTitle'] = html_entity_decode( $item->get_title() );

			// id
			$mcIds = $item->get_item_tags(self::$MOVIECLIPS_XMLNS, 'id');
			$clipData['mcId'] = $mcIds[0]['data'];

			// movie name
			$objectIds = $item->get_item_tags(self::$MOVIECLIPS_XMLNS, 'object_ids');
			$clipData['titleName'] = html_entity_decode( $objectIds[0]['child'][self::$MOVIECLIPS_XMLNS]['imdb_id'][0]['attribs']['']['name'] );
			$clipData['freebaseMid'] = $objectIds[0]['child'][self::$MOVIECLIPS_XMLNS]['freebase_mid'][0]['data'];

			// description, thumbnails, movie year, duration
			if ($enclosure = $item->get_enclosure()) {
				$thumbnails = (array) $enclosure->get_thumbnails();
				$numThumbnails = sizeof($thumbnails);
				if ($numThumbnails) {
					if ($numThumbnails > 1) {
						$clipData['thumbnail'] = $thumbnails[1];
					}
					else {
						$clipData['thumbnail'] = $thumbnails[0];
					}

					$thumbnailParts = explode('/', $clipData['thumbnail']);
					array_pop($thumbnailParts);	// filename. throw away
					$movieAndYear = array_pop($thumbnailParts);
					$year = substr($movieAndYear, -4);
					if (is_numeric($year)) {
						$clipData['year'] = $year;
					}
				}
				
				// remove the title from the description
				$description = strip_tags( html_entity_decode( $item->get_description() ) );
				$description = str_replace("{$clipData['titleName']} ({$clipData['year']}) - {$clipData['clipTitle']} - ", '', $description);
				// description may have commas, need to escape these before video metadata is imploded by comma
				$clipData['description'] = str_replace(',', '&#44;', $description);	
				
				$clipData['duration'] = $enclosure->get_duration();
			}

			$msg = '';
			$articlesCreated += $this->createVideoPageForPartnerVideo(VideoPage::V_MOVIECLIPS, $clipData, $msg);
			if ($msg) {
				print "ERROR: $msg\n";
			}
		}

		return $articlesCreated;
	}
	
	public function importFromRealgravity($keyword) {
		global $parseOnly;
		
		$articlesCreated = 0;		
		$page = 1;

		do {
			$numVideos = 0;
	
			$url = self::initRealgravityVideosApiUrl($keyword, $page++);

			$info = array();
			!$parseOnly && print("Connecting to $url...\n");

			$xmlContent = $this->getUrlContent($url);

			if (!$xmlContent) {
				print("ERROR: problem downloading content!\n");
				return 0;
			}

			$doc = new DOMDocument( '1.0', 'UTF-8' );
			@$doc->loadXML( $xmlContent );
			$videos = $doc->getElementsByTagName('video');
			$numVideos = $videos->length;
			!$parseOnly && print("Found $numVideos videos...\n");
			for ($i=0; $i<$numVideos; $i++) {
				$clipData = array();
				$video = $videos->item($i);
				$clipData['clipTitle'] = $video->getElementsByTagName('title')->item(0)->textContent;
				$clipData['rgGuid'] = $video->getElementsByTagName('guid')->item(0)->textContent;
				$clipData['thumbnail'] = $video->getElementsByTagName('thumbnail-url')->item(0)->textContent;
				$clipData['duration'] = $video->getElementsByTagName('duration')->item(0)->textContent;
				if ($video->getElementsByTagName('source-video-props')->item(0)) {			
					$sourceVideoPropsTxt = $video->getElementsByTagName('source-video-props')->item(0)->textContent;
					$sourceVideoProps = explode('|', $sourceVideoPropsTxt);
					if (sizeof($sourceVideoProps)) {
						$clipData['aspectRatio'] = $sourceVideoProps[0];
					}
				}
				if (empty($clipData['aspectRatio'])) {
					$clipData['aspectRatio'] = self::$REALGRAVITY_DIMENSIONS;
				}
				
				$description = $video->getElementsByTagName('description')->item(0)->textContent;
				$description = str_replace("\n", '<br/>', $description);
				// description may have commas, need to escape these before video metadata is imploded by comma
				$clipData['description'] = str_replace(',', '&#44;', $description);	
				
				//@todo tag list

				$msg = '';
				
				$articlesCreated += $this->createVideoPageForPartnerVideo(VideoPage::V_REALGRAVITY, $clipData, $msg);
				if ($msg) {
					print "ERROR: $msg\n";
				}
			}
		}
		while ($numVideos == self::$REALGRAVITY_PAGE_SIZE);
		
		return $articlesCreated;
	}
	
	private static function initRealgravityVideosApiUrl($keyword, $page=1) {
		global $startDate, $endDate;
		
		$url = str_replace('$1', self::$REALGRAVITY_API_KEY, self::$REALGRAVITY_VIDEOS_URL );
		$url = str_replace('$2', self::$REALGRAVITY_PROVIDER_IDS['MACHINIMA'], $url);
		$url = str_replace('$3', urlencode($keyword), $url);
		$url = str_replace('$4', self::$REALGRAVITY_PAGE_SIZE, $url);
		$url = str_replace('$5', $page, $url);
		if ($startDate && $endDate) {
			$url .= '&date_range=' . $startDate . '..' . $endDate;
		}
		return $url;
	}
	
	protected function isClipTypeBlacklisted($provider, array $clipData) {
		// assume that a clip with properties that match exactly undesired
		// values should not be imported. This assumption will have to
		// change if we consider values that fall into a range, such as
		// duration < MIN_VALUE
		if (is_array(self::$CLIP_TYPE_BLACKLIST[$provider])) {
			$arrayIntersect = array_intersect(self::$CLIP_TYPE_BLACKLIST[$provider], $clipData);
			if (!empty($arrayIntersect) && $arrayIntersect == self::$CLIP_TYPE_BLACKLIST[$provider]) {
				return true;
			}
		}
		
		return false;
	}

	protected function getUrlContent($url) {
		return Http::get($url);
	}
	
	protected static function getApiQueryTermsFromFileContents($file) {
		$terms = array();

		$lines = explode("\n", $file);

		foreach ($lines as $line) {
			$line = trim($line);
			if ($line) {
				$terms[] = $line;
			}
		}

		return $terms;
	}
	
	public static function generateNameForPartnerVideo($provider, array $data) {
		$name = '';

		switch ($provider) {
			case VideoPage::V_SCREENPLAY:
				$altDescription = '';
				$altDescription .= !empty($data['trailerType']) ? $data['trailerType'] . ' ' : '';
				$altDescription .= !empty($data['trailerVersion']) ? $data['trailerVersion'] . ' ' : '';
				$altDescription .= "({$data['eclipId']})";
				$description = ($data['description']) ? $data['description'] : $altDescription;
				if (startsWith($description, 'Trailer ')) {
					// add trailer type to description
					if (!empty($data['trailerType'])) {
						$description = $data['trailerType'] . ' ' . $description;
					}
				}
				$name = sprintf("%s - %s", self::generateTitleNameForPartnerVideo($provider, $data), $description);										
				break;
			case VideoPage::V_MOVIECLIPS:
				$name = sprintf("%s - %s", self::generateTitleNameForPartnerVideo($provider, $data), $data['clipTitle']);
				break;
			case VideoPage::V_REALGRAVITY:
				$name = $data['clipTitle'];
				break;
			default:
		}
		

		// sanitize title
		$name = preg_replace(Title::getTitleInvalidRegex(), ' ', $name);
		// get rid of slashes. these are technically allowed in article
		// titles, but they refer to subpages, which videos don't have
		$name = str_replace('  ', ' ', $name);

		$name = substr($name, 0, VideoPage::MAX_TITLE_LENGTH);	// DB column Image.img_name has size 255			

		return $name;
	}

	public static function generateCategoriesForPartnerVideo($provider, array $data) {
		global $wgWikiaVideoProviders, $addlCategories;

		$categories = !empty($addlCategories) ? $addlCategories : array();
		$categories[] = $wgWikiaVideoProviders[$provider];

		switch ($provider) {
			case VideoPage::V_SCREENPLAY:
				$categories[] = self::generateTitleNameForPartnerVideo($provider, $data);	
				if (!empty($data['trailerVersion'])) {
					$categories[] = $data['trailerVersion'];
				}
				if (stripos($data['titleName'], '(VG)') !== false) {
					$categories[] = 'Games';
				}
				else {
					$categories[] = 'Entertainment';
				}
				break;
			case VideoPage::V_MOVIECLIPS:
				$categories[] = self::generateTitleNameForPartnerVideo($provider, $data);
				$categories[] = 'Entertainment';
				break;
			case VideoPage::V_REALGRAVITY:
				$categories[] = 'Games';
				break;
			default:
				return array();
		}

		return $categories;
	}
	
	public static function generateTitleNameForPartnerVideo($provider, array $data) {
		$name = '';
		
		switch ($provider) {
			case VideoPage::V_SCREENPLAY:
			case VideoPage::V_MOVIECLIPS:
				if (strpos($data['titleName'], "({$data['year']})") === false) {
					$name = $data['titleName'] . ' (' . $data['year'] . ')';					
				}
				else {
					$name = $data['titleName'];					
				}
				break;
			case VideoPage::V_REALGRAVITY:
				// do nothing
				break;
			default:
		}
		
		return $name;		
	}
	
	public function makeTitleSafe($name) {
		return Title::makeTitleSafe(NS_LEGACY_VIDEO, str_replace('#', '', $name));    // makeTitleSafe strips '#' and anything after. just leave # out
	}		
	
	protected static function sanitizeDataForPartnerVideo($provider, &$data) {
		switch ($provider) {
			case VideoPage::V_SCREENPLAY:
				$data['titleName'] = str_replace('  ', ' ', $data['titleName'] );
				if (!empty($data['description'])) {
					$data['description'] = str_replace('  ', ' ', $data['description'] );					
				}
				break;
			case VideoPage::V_MOVIECLIPS:
				$data['titleName'] = str_replace('  ', ' ', $data['titleName'] );
				break;
			case VideoPage::V_REALGRAVITY:
				$data['clipTitle'] = str_replace('  ', ' ', $data['clipTitle'] );
				break;
			default:
		}
	}

	public function createVideoPageForPartnerVideo($provider, array $data, &$msg) {
		global $debug, $parseOnly, $filename;

		$id = null;
		$metadata = null;	
		
		$name = self::generateNameForPartnerVideo($provider, $data);

		switch ($provider) {
			case VideoPage::V_SCREENPLAY:
				$id = $data['eclipId'];

				if (empty($data['stdBitrateCode'])) {
					$msg = "no video encoding exists for $name: clip $id";
					return 0;
				}

				$doesHdExist = (int) !empty($data['hdMp4Url']);
				$metadata = array($data['stdBitrateCode'], $doesHdExist, $data['duration'], $data['jpegBitrateCode']);
				break;
			case VideoPage::V_MOVIECLIPS:
				$id = $data['mcId'];
				$metadata = array($data['thumbnail'], $data['duration'], $data['description']);
				break;
			case VideoPage::V_REALGRAVITY:
				$id = $data['rgGuid'];
				$metadata = array($data['aspectRatio'], $data['thumbnail'], $data['duration'], $data['description']);
				break;
			default:
				$msg = "unsupported provider $provider";
				return 0;
		}

		$title = $this->makeTitleSafe($name);
		if(is_null($title)) {
			$msg = "article title was null: clip id $id. name: $name";
			return 0;
		}
		
		if( !$debug && !$parseOnly && $title->exists() ) {
			// don't output duplicate error message
			return 0;
		}	

		$categories = self::generateCategoriesForPartnerVideo($provider, $data);
		$categoryStr = '';
		foreach ($categories as $categoryName) {
			$category = Category::newFromName($categoryName);
			if ($category instanceof Category) {
				$categoryStr .= '[[' . $category->getTitle()->getFullText() . ']]';
			}
		}

		$video = F::build('VideoPage', array(&$title));
		
		if ($video instanceof VideoPage) {
			$video->loadFromPars( $provider, $id, $metadata );
			$video->setName( $name );
			if ($parseOnly) {
				if (!empty($data['titleName']) && !empty($data['year'])) {
					printf("%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\n", 
						basename($filename), 
						$id, 
						$data['titleName'], 
						$data['year'], 
						$title->getText(), 
						$title->getFullURL(),
						self::generateTitleNameForPartnerVideo($provider, $data), 
						$data['duration'],
						implode(',', $metadata), 
						implode(',', $categories));
				}
				else {
					printf("%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\n", 
						basename($filename), 
						$id, 
						$title->getText(), 
						$title->getFullURL(),
						self::generateTitleNameForPartnerVideo($provider, $data), 
						$data['duration'],
						implode(',', $metadata), 
						implode(',', $categories));					
				}
			}
			elseif ($debug) {
				print "parsed partner clip id $id. name: {$title->getText()}. data: " . implode(',', $metadata) . ". categories: " . implode(',', $categories) . "\n";
			}
			else {
				$video->save($categoryStr);
				print "Ingested {$title->getText()} from partner clip id $id. {$title->getFullURL()}\n\n";
				print "sleeping " . self::THROTTLE_INTERVAL . " second(s)...\n";
				sleep(self::THROTTLE_INTERVAL);
			}
			return 1;
		}

		return 0;
	}
	
	protected function getPartnerVideoIngestionDataFromSource() {
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
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		
		$aTables = array(
			'city_variables',
			'city_variables_pool',
			'city_list',
		);
		$varName = mysql_real_escape_string(self::$PARTNER_VIDEO_INGESTION_DATA_VARNAME);
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

		return $aWikis;
	}
	
	public function getPartnerVideoIngestionData() {
		$data = array();
		
		// merge data from datasource into a data structure keyed by 
		// partner API search keywords. Value is an array of categories
		// relevant to wikis
		$rawData = $this->getPartnerVideoIngestionDataFromSource();
		foreach ($rawData as $cityId=>$cityData) {
			if (is_array($cityData)) {
				foreach (self::$PARTNER_VIDEO_INGEESTION_DATA_FIELDS as $field) {
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
		
		return $data;
	}
}
