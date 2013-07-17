<?php

/**
 * Class IvaFeedIngester
 */
class IvaFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'IvaApiWrapper';
	protected static $PROVIDER = 'iva';
	protected static $FEED_URL = 'http://api.internetvideoarchive.com/1.0/DataService/VideoAssets?$top=$1&$skip=$2&$filter=$3&$expand=$4&$format=json&developerid=$5';
	protected static $ASSET_URL = 'http://www.videodetective.net/video.mp4?cmd=6&fmt=4&customerid=$1&videokbrate=750&publishedid=$2&e=$3';

	private static $VIDEO_SETS = array(
		'Wiggles',
		'Futurama',
		'Winnie the Pooh',
		'Shameless',
		'Hey Arnold',
		'Huntik',
		'Rugrats',
		'Digimon',
		'Power Rangers',
		'South Park ',
		'Alvin and the Chipmunks',
		'Animaniacs',
		'Kamen Rider',
		'Bakugan',
		'Lost',
		'Full Metal Alchemist',
		'Teen Titans',
		'True Blood',
		'iCarly',
		'Dexter',
		'Arthur',
		'X-Files',
		'Xiaolin',
		'Blues Clues',
		'Naruto',
		'Yu-Gi-Oh!',
		'Walking Dead',
		'Dragon Ball',
		'Bleach',
		'Glee',
		'My Little Pony',
		'Vampire Diaries',
		'Game of Thrones',
		'Doctor Who',
		'Gundam',
		'Degrassi',
		'The Simpsons',
		'Thomas the Tank Engine',
		'Young Justice',
		'Batman',
		'Spongebob',
		'Spartacus',
		'Family Guy',
		'How I Met Your Mother',
		'Stargate',
		'Smallville',
		'Big Bang Theory',
		'Breaking Bad',
		'Buffy',
		'Criminal Minds',
		'Survivor',
		'American Dad',
		'Archer',
		'Dance Moms',
		'Merlin',
		'Grimm',
		'24',
		'Sons of Anarchy',
		'Saint Seiya',
		'Bones',
		'NCIS',
		'Being Human',
		'American Horror Story',
		'Law and Order',
		'Person of Interest',
		'Sailor Moon',
		'The Mentalist',
		'Friends',
		'YuYu Hakusho',
		'House',
		'Revenge',
		'Justified',
		'The Office',
		'CSI',
		'Prison Break',
		'Suits',
		'The Cleveland Show',
		'White Collar',
		'H2O: Just Add Water',
		'Fringe',
		'Misfits',
		'Looney Tunes',
		'Psych',
		'SMASH',
		'Avengers',
		'Amazing Race',
		'Glee Project',
		'Veggie Tales',
		'The Following',
		'Twilight',
		'The Hunger Games',
	);

	// These are for a Series, TV Show, Season and Episode
	private static $TV_MEDIA_IDS = array( 24, 25, 26, 27 );

	const API_PAGE_SIZE = 100;

	/**
	 * Import IVA content
	 * @param string $content
	 * @param array $params
	 * @return int
	 */
	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		include_once( dirname( __FILE__ ).'/../../../cldr/CldrNames/CldrNamesEn.php' );

		$debug          = !empty( $params['debug'] );
		$startDate      = !empty( $params['startDate'] )      ? $params['startDate'] : '';
		$endDate        = !empty( $params['endDate'] )        ? $params['endDate'] : '';
		$addlCategories = !empty( $params['addlCategories'] ) ? $params['addlCategories'] : array();
		$remoteAsset    = !empty( $params['remoteAsset'] );
		$createParams = array( 'addlCategories' => $addlCategories, 'debug' => $debug, 'remoteAsset' => $remoteAsset );

		$articlesCreated = 0;

		// Ingest any content from the defined video sets above
		foreach( self::$VIDEO_SETS as $videoSet ) {
			$page = 0;
			do {
				// Get the URL that selects specific video sets based on title matches
				$url = $this->makeSetFeedURL( $videoSet, $startDate, $endDate, $page++ );

				// Try to ingest the videos from this URL
				$result = $this->ingestVideoURL( $url, $createParams, $videoSet );

				// If we get back 'false' (different than zero) then we've hit an error
				if ( $result === false ) {
					return 0;
				}
			} while ( $result['found'] == self::API_PAGE_SIZE );
		}
		$articlesCreated += $result['created'];

		/* 2013-07-16 : VideoSprint28 : VID-536
		   Content didn't really want all TV content
		   Delete these lines on or after VideoSprint30 in case they change their minds

		// Ingest ALL TV content
		$page = 0;
		do {
			// Get the URL that selects video in any of the TV categories
			$url = $this->makeTVFeedURL( $startDate, $endDate, $page++ );

			// Try to ingest the videos from this URL
			$numVideos = $this->ingestVideoURL( $url, $createParams, 'TV' );

			// If we get back 'false' (different than zero) then we've hit an error
			if ( $numVideos === false ) {
				return 0;
			}
		} while ( $numVideos == self::API_PAGE_SIZE );
		$articlesCreated += $result['created'];
		*/

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * Create the feed URL for a specific $videoSet (basically a match on title
	 * @param $videoSet - A substring that should match part of the video title
	 * @param $startDate - Unixtime for beginning of modified-on date range
	 * @param $endDate - Unixtime for ending of modified-on date range
	 * @param $page - The page of results to fetch
	 * @return string - A feed URL
	 */
	private function makeSetFeedURL( $videoSet, $startDate, $endDate, $page ) {
		$filter = "(DateModified gt datetime'$startDate') " .
			"and (DateModified le datetime'$endDate') ".
			"and (substringof('$videoSet', Title) eq true)";

		return $this->initFeedUrl( $filter, $page );
	}

	/**
	 * Craete the feed URL for TV resources
	 * @param $startDate - Unixtime for beginning of modified-on date range
	 * @param $endDate - Unixtime for ending of modified-on date range
	 * @param $page - The page of results to fetch
	 * @return string - A feed URL
	 */
	private function makeTVFeedURL( $startDate, $endDate, $page ) {

		// The example query shows this kind of nesting so just do it ...
		// http://www.internetvideoarchive.com/IVA/support/documentation/data/iva-odata-api/example-queries
		$matchTV = '';
		foreach ( self::$TV_MEDIA_IDS as $id ) {
			if ( empty($matchTV) ) {
				$matchTV = "(MediaId eq $id)";
			} else {
				$matchTV = "($matchTV or (MediaId eq $id))";
			}
		}

		$filter = "(DateModified gt datetime'$startDate') " .
			"and (DateModified le datetime'$endDate') ".
			"and $matchTV";

		return $this->initFeedUrl( $filter, $page );
	}

	/**
	 * Construct the URL given a start and end date and the result page to retrieve.
	 * @param $filter - The filter to include in the URL to select the correct video metadata
	 * @param $page - The page of results to fetch
	 * @return string - A feed URL
	 */
	private function initFeedUrl( $filter, $page ) {
		$url = str_replace( '$1', self::API_PAGE_SIZE, static::$FEED_URL );
		$url = str_replace( '$2', self::API_PAGE_SIZE * $page, $url );
		$url = str_replace( '$3', urlencode( $filter ), $url );

		$expand = array(
			'EntertainmentProgram',
			'Descriptions',
			'VideoAssetScreenCapture',
			'MediaType',
			'EntertainmentProgram/MovieMpaa',
			'EntertainmentProgram/TvRating',
			'EntertainmentProgram/MovieCategory',
			'EntertainmentProgram/TvCategory',
			'EntertainmentProgram/ProgramToPerformerMaps/Performer',
			'LanguageSpoken',
			'EntertainmentProgram/GameWarning',
		);

		$url = str_replace( '$4', implode( ',', $expand ), $url );
		$url = str_replace( '$5', F::app()->wg->IvaApiConfig['DeveloperId'], $url );

		return $url;
	}

	/**
	 * Given an IVA video asset URL, request the content and ingest all the videos returned
	 * @param $url - The IVA URL to ingest video from
	 * @param $createParams
	 * @param $defaultKeyword
	 * @return bool - True if the ingestion succeeded, false otherwise
	 */
	private function ingestVideoURL( $url, $createParams, $defaultKeyword = null ) {
		wfProfileIn( __METHOD__ );

		// Retrieve the video data from IVA
		$videos = $this->requestData( $url );
		if ( $videos === false ) {
			return false;
		}

		$numVideos = count( $videos );
		print( "Found $numVideos videos...\n" );

		$articlesCreated = 0;
		foreach( $videos as $video ) {
			$clipData = array();
			$clipData['titleName'] =  empty( $video['DisplayTitle'] ) ? trim( $video['Title'] ) : trim( $video['DisplayTitle'] );
			$clipData['videoId'] = $video['Publishedid'];

			if ( !empty($video['ExpirationDate']) ) {
				print "Skip: {$clipData['titleName']} (Id:{$clipData['videoId']}) has expiration date.\n";
				continue;
			}

			if ( !empty($video['TargetCountryId']) && $video['TargetCountryId'] != -1 ) {
				print "Skip: {$clipData['titleName']} (Id:{$clipData['videoId']}) has regional restrictions.\n";
				continue;
			}

			$clipData['thumbnail'] = $video['VideoAssetScreenCapture']['URL'];
			$clipData['duration'] = $video['StreamLengthinseconds'];

			$clipData['published'] = '';
			if ( preg_match('/Date\((\d+)\)/', $video['DateCreated'], $matches) ) {
				$clipData['published'] = $matches[1]/1000;
			}

			$clipData['category'] = trim( $video['MediaType']['Media'] );
			$clipData['description'] = trim( $video['Descriptions']['ItemDescription'] );
			$clipData['hd'] = ( $video['HdSource'] == 'true' ) ? 1 : 0;
			$clipData['tags'] = trim( $video['EntertainmentProgram']['Tagline'] );
			$clipData['provider'] = 'iva';

			$clipData['language'] = '';
			// $languageNames comes from cldr extension
			if ( !empty( $video['LanguageSpoken']['LanguageName'] ) && !empty( $languageNames ) ) {
				$lang = trim( $video['LanguageSpoken']['LanguageName'] );
				$clipData['language'] =  array_search( $lang, $languageNames );
			}

			$clipData['industryRating'] = '';
			if ( !empty( $video['EntertainmentProgram']['MovieMpaa']['Rating'] ) ) {
				$clipData['industryRating'] = $this->getIndustryRating( $video['EntertainmentProgram']['MovieMpaa']['Rating'] );
			} else if ( !empty( $video['EntertainmentProgram']['TvRating']['Rating'] ) ) {
				$clipData['industryRating'] = $this->getIndustryRating( $video['EntertainmentProgram']['TvRating']['Rating'] );
			} else if ( !empty( $video['EntertainmentProgram']['GameWarning']['Warning'] ) ) {
				$clipData['industryRating'] = $this->getIndustryRating( $video['EntertainmentProgram']['GameWarning']['Warning'] );
			}

			$clipData['ageGate'] = $this->getAgeGate( $clipData['industryRating'] );
			$clipData['ageRequired'] = $clipData['ageGate'];

			$clipData['genres'] = '';
			$keywords = $defaultKeyword ? array( $defaultKeyword ) : array();
			if ( !empty( $video['EntertainmentProgram']['MovieCategory']['Category'] ) ) {
				$clipData['genres'] = $video['EntertainmentProgram']['MovieCategory']['Category'];
				$keywords[] = 'Movies';
			} else if ( !empty( $video['EntertainmentProgram']['TvCategory']['Category'] ) ) {
				$clipData['genres'] = $video['EntertainmentProgram']['TvCategory']['Category'];
				$keywords[] = 'TV';
			} else if ( !empty( $video['EntertainmentProgram']['GameCategory']['Category'] ) ) {
				$clipData['genres'] = $video['EntertainmentProgram']['GameCategory']['Category'];
				$keywords[] = 'Gaming';
			}

			$clipData['keywords'] = implode( ', ', $keywords );

			$actors = array();
			if ( !empty( $video['EntertainmentProgram']['ProgramToPerformerMaps']['results'] ) ) {
				foreach( $video['EntertainmentProgram']['ProgramToPerformerMaps']['results'] as $performer ) {
					$actors[] = trim( $performer['Performer']['FullName'] );
				}
			}
			$clipData['actors'] = implode( ', ', $actors );

			$msg = '';
			$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
			if ( $msg ) {
				print "ERROR: $msg\n";
			}
		}

		wfProfileOut( __METHOD__ );

		return array("created" => $articlesCreated,
					 "found"   => $numVideos);
	}

	/**
	 * Call out to IVA for the video metadata from the URL passed as $url
	 * @param $url - The IVA URL to pull video metadata from
	 * @return array|bool
	 */
	private function requestData( $url ) {

		print( "Connecting to $url...\n" );

		$req = MWHttpRequest::factory( $url );
		$status = $req->execute();
		if ( $status->isOK() ) {
			$response = $req->getContent();
		} else {
			print( "ERROR: problem downloading content.\n" );
			wfProfileOut( __METHOD__ );

			return false;
		}

		// parse response
		$response = json_decode( $response, true );
		return ( empty($response['d']['results']) ) ? array() : $response['d']['results'];
	}

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $data - Video data
	 * @param $addlCategories - Any additional categories to add
	 * @return array - A list of category names
	 */
	public function generateCategories( array $data, $addlCategories ) {
		wfProfileIn( __METHOD__ );

		$categories = !empty($addlCategories) ? $addlCategories : array();

		if ( !empty($data['keywords']) ) {
			$keywords = explode( ',', $data['keywords'] );

			foreach( $keywords as $keyword ) {
				$categories[] = trim( $keyword );
			}
		}

		if ( !empty($data['categoryName']) ) {
			$categories[] = $data['categoryName'];
		}

		if ( !in_array( 'IVA', $categories) ) {
			$categories[] = 'IVA';
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}

	/**
	 * Grab the 'titleName' element of the video data
	 * @param array $data - Video data
	 * @return string - The video title
	 */
	protected function generateName( array $data ) {
		wfProfileIn( __METHOD__ );

		$name = $data['titleName'];

		wfProfileOut( __METHOD__ );

		return $name;
	}

	/**
	 * Pull out all the metadata we consider interesting for this video
	 * @param array $data - Video data
	 * @param $errorMsg - Store any error we encounter
	 * @return array|int - An associative array of meta data or zero on error
	 */
	protected function generateMetadata( array $data, &$errorMsg ) {
		if ( empty($data['videoId']) ) {
			$errorMsg = 'no video id exists';
			return 0;
		}

		$metadata = array(
			'videoId'        => $data['videoId'],
			'hd'             => $data['hd'],
			'duration'       => $data['duration'],
			'published'      => $data['published'],
			'ageGate'        => $data['ageGate'],
			'thumbnail'      => $data['thumbnail'],
			'category'       => $data['category'],
			'description'    => $data['description'],
			'keywords'       => $data['keywords'],
			'tags'           => $data['tags'],
			'industryRating' => $data['industryRating'],
			'provider'       => $data['provider'],
			'language'       => $data['language'],
			'genres'         => $data['genres'],
			'actors'         => $data['actors'],
			'ageRequired'    => $data['ageRequired'],
		);

		return $metadata;
	}

	/**
	 * Massage some video metadata and generate URLs to this video's assets
	 * @param string $name
	 * @param array $data
	 * @return array $data
	 */
	protected function generateRemoteAssetData( $name, $data ) {
		$data['name'] = $name;
		$data['duration'] = $data['duration'] * 1000;
		$data['published'] = empty( $data['published'] ) ? '' : strftime( '%Y-%m-%d', $data['published'] );

		$url = str_replace( '$1', F::app()->wg->IvaApiConfig['AppId'], static::$ASSET_URL );
		$url = str_replace( '$2', $data['videoId'], $url );

		$expired = 1609372800; // 2020-12-31
		$url = str_replace( '$3', $expired, $url );

		$hash = $this->generateHash( $url );
		$url .= '&h='.$hash;

		$data['url'] = array(
			'flash' => $url,
			'iphone' => $url,
		);

		return $data;
	}

	/**
	 * Generate an MD5 hash from the IVA App Key combined with the URL
	 * @param string $url - The URL to base the hash on
	 * @return string $hash - The MD5 hash
	 */
	protected function generateHash( $url ) {
		$hash = md5( strtolower( F::app()->wg->IvaApiConfig['AppKey'].$url ) );

		return $hash;
	}
}