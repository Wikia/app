<?php

/**
 * Class IvaFeedIngester
 */
class IvaFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'IvaApiWrapper';
	protected static $PROVIDER = 'iva';
	protected static $FEED_URL = 'http://api.internetvideoarchive.com/1.0/DataService/EntertainmentPrograms?$top=$1&$skip=$2&$filter=$3&$expand=$4&$format=json&developerid=$5';
	protected static $ASSET_URL = 'http://www.videodetective.net/video.mp4?cmd=6&fmt=4&customerid=$1&videokbrate=750&publishedid=$2&e=$3';

	private static $VIDEO_SETS = array(
		'Wiggles' => array( 'Wiggles' ),
		'Futurama' => array( 'Futurama' ),
		'Winnie the Pooh' => array( 'Winnie the Pooh' ),
		'Huntik' => array( 'Huntik' ),
		'Rugrats' => array( 'Rugrats' ),
		'Digimon' => array( 'Digimon' ),
		'Power Rangers' => array( 'Power Rangers' ),
		'South Park' => array( 'South Park' ),
		'Alvin and the Chipmunks' => array( 'Alvin and the Chipmunks' ),
		'Animaniacs' => array( 'Animaniacs' ),
		'Kamen Rider' => array( 'Kamen Rider' ),
		'Bakugan' => array( 'Bakugan' ),
		'Lost' => array ( 1307 ),
		'Full Metal Alchemist' => array( 'Full Metal Alchemist' ),
		'Teen Titans' => array( 'Teen Titans' ),
		'True Blood' => array( 'True Blood' ),
		'iCarly' => array( 'iCarly' ),
		'Dexter' => array( 'Dexter' ),
		'Arthur' => array ( 266094, 60437, 664249, 495354, 15190, 490750, 897802, 897802, 866981 ),
		'X-Files' => array( 'X-Files' ),
		'Xiaolin' => array( 'Xiaolin' ),
		'Blues Clues' => array( 'Blues Clues' ),
		'Naruto' => array( 'Naruto' ),
		'Yu-Gi-Oh!' => array( 'Yu-Gi-Oh!' ),
		'Walking Dead' => array( 'Walking Dead' ),
		'Dragon Ball' => array( 'Dragon Ball' ),
		'Bleach' => array( 604483, 611394, 20912, 189824 ),
		'Glee' => array( 'Glee' ),
		'My Little Pony' => array( 'My Little Pony' ),
		'Vampire Diaries' => array( 'Vampire Diaries' ),
		'Game of Thrones' => array( 'Game of Thrones', 785881, 722311 ),
		'Doctor Who' => array( 'Doctor Who' ),
		'Gundam' => array( 'Gundam' ),
		'Degrassi' => array( 'Degrassi' ),
		'The Simpsons' => array( 'The Simpsons' ),
		'Thomas the Tank Engine' => array( 'Thomas the Tank Engine' ),
		'Young Justice' => array( 'Young Justice' ),
		'Batman' => array( 'Batman' ),
		'Spongebob' => array( 'Spongebob' ),
		'Spartacus' => array( 'Spartacus' ),
		'Family Guy' => array( 'Family Guy' ),
		'How I Met Your Mother' => array( 'How I Met Your Mother' ),
		'Stargate' => array( 'Stargate' ),
		'Smallville' => array( 'Smallville' ),
		'Big Bang Theory' => array( 'Big Bang Theory' ),
		'Breaking Bad' => array( 'Breaking Bad' ),
		'Buffy' => array( 'Buffy' ),
		'Criminal Minds' => array( 'Criminal Minds' ),
		'Survivor' => array( 'Survivor' ),
		'American Dad' => array( 'American Dad' ),
		'Archer' => array( 457165 ),
		'Dance Moms' => array( 'Dance Moms' ),
		'Merlin' => array( 665766 ),
		'Grimm' => array( 'Grimm' ),
		'24' => array( 665302 ),
		'Sons of Anarchy' => array( 'Sons of Anarchy' ),
		'Saint Seiya' => array( 'Saint Seiya' ),
		'Bones' => array( 156185 ),
		'NCIS' => array( 'NCIS' ),
		'Being Human' => array( 'Being Human' ),
		'American Horror Story' => array( 'American Horror Story' ),
		'Law and Order' => array( 'Law and Order' ),
		'Person of Interest' => array( 'Person of Interest' ),
		'Sailor Moon' => array( 'Sailor Moon' ),
		'The Mentalist' => array( 'The Mentalist' ),
		'Friends' => array( 156185 ),
		'YuYu Hakusho' => array( 'YuYu Hakusho' ),
		'House' => array( 422384 ),
		'Revenge' => array( 618690 ),
		'Justified' => array( 877316 ),
		'The Office' => array( 558636, 946809 ),
		'CSI' => array( 'CSI' ),
		'Prison Break' => array( 'Prison Break' ),
		'Suits' => array( 976703 ),
		'The Cleveland Show' => array( 'The Cleveland Show' ),
		'White Collar' => array( 'White Collar' ),
		'H2O: Just Add Water' => array( 'H2O: Just Add Water' ),
		'Fringe' => array( 459388 ),
		'Misfits' => array( 828965 ),
		'Looney Tunes' => array( 'Looney Tunes' ),
		'Psych' => array( 839810 ),
		'SMASH' => array( 229948 ),
		'Avengers' => array( 7627, 225128, 102346 ),
		'Amazing Race' => array( 'Amazing Race' ),
		'Glee Project' => array( 'Glee Project' ),
		'Veggie Tales' => array( 'Veggie Tales' ),
		'The Following' => array( 'The Following' ),
		'Twilight' => array( 980633, 924807, 15097, 151421, 149755 ),
		'Hunger Games' => array( 'Hunger Games' ),
	);

	private static $EXCLUDE_MEDIA_IDS = array( 3, 12, 14, 15, 33, 36 );	// exclude song types

	const API_PAGE_SIZE = 100;

	/**
	 * Import IVA content
	 * @param string $content
	 * @param array $params
	 * @return int
	 */
	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$debug = !empty( $params['debug'] );
		$remoteAsset = !empty( $params['remoteAsset'] );
		$startDate = empty( $params['startDate'] ) ? '' : $params['startDate'];
		$endDate = empty( $params['endDate'] ) ? '' : $params['endDate'];
		$addlCategories = empty( $params['addlCategories'] ) ? array() : $params['addlCategories'];
		$createParams = array(
			'addlCategories' => $addlCategories,
			'debug' => $debug,
			'remoteAsset' => $remoteAsset
		);

		$articlesCreated = 0;

		// Ingest any content from the defined video sets above
		foreach( self::$VIDEO_SETS as $keyword => $videoSet ) {
			$videoParams['keyword'] = $keyword;

			foreach( $videoSet as $value ) {
				$videoParams['videoSet'] = $value;
				$videoParams['isPublishedId'] = ( is_numeric( $value ) );

				$result = $this->ingestVideos( $createParams, $startDate, $endDate, $videoParams );
				if ( $result === false ) {
					wfProfileOut( __METHOD__ );
					return 0;
				}

				$articlesCreated += $result;
			}
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * ingest videos
	 * @param array $createParams
	 * @param integer $startDate - Unixtime for beginning of modified-on date range
	 * @param integer $endDate - Unixtime for ending of modified-on date range
	 * @param array $videoParams
	 * @return integer|false $articlesCreated - number of articles created or false
	 */
	private function ingestVideos( $createParams, $startDate, $endDate, $videoParams ) {
		wfProfileIn( __METHOD__ );

		// include cldr extension for language, subtitle, target country
		include( dirname( __FILE__ ).'/../../../cldr/CldrNames/CldrNamesEn.php' );

		$page = 0;
		$articlesCreated = 0;

		do {
			// Get the URL that selects specific video sets based on title matches
			$url = $this->makeSetFeedURL( $videoParams, $startDate, $endDate, $page++ );

			// Retrieve the video data from IVA
			$programs = $this->requestData( $url );
			if ( $programs === false ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$numPrograms = count( $programs );
			print( "Found $numPrograms Entertainment Programs...\n" );

			foreach( $programs as $program ) {
				$clipData = array();

				$program['title'] = empty( $program['DisplayTitle'] ) ? trim( $program['Title'] ) : trim( $program['DisplayTitle'] );

				// get series
				$clipData['series'] = empty( $videoParams['series'] ) ? $program['title'] : $videoParams['series'];

				if ( isset( $program['OkToEncodeAndServe'] ) && $program['OkToEncodeAndServe'] == false ) {
					print "Skip: {$clipData['series']} (Publishedid:{$program['Publishedid']}) has OkToEncodeAndServe set to false.\n";
					continue;
				}

				// get season
				$clipData['season'] = empty( $videoParams['season'] ) ? '' : $videoParams['season'];
				if ( empty( $clipData['season'] ) && $program['MediaId'] == 26 ) {	// media type = season (26)
					 $clipData['season'] = empty( $program['DisplayTitle'] ) ? trim( $program['Title'] ) : trim( $program['DisplayTitle'] );
				}

				// get episode
				$clipData['episode'] = empty( $videoParams['episode'] ) ? '' : $videoParams['episode'];
				if ( empty( $clipData['episode'] ) && $program['MediaId'] == 27 ) {	// media type = episode (27)
					 $clipData['episode'] = empty( $program['DisplayTitle'] ) ? trim( $program['Title'] ) : trim( $program['DisplayTitle'] );
				}

				$clipData['tags'] = trim( $program['Tagline'] );

				$clipData['industryRating'] = '';
				if ( !empty( $program['MovieMpaa']['Rating'] ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $program['MovieMpaa']['Rating'] );
				} else if ( !empty( $program['TvRating']['Rating'] ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $program['TvRating']['Rating'] );
				} else if ( !empty( $program['GameWarning']['Warning'] ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $program['GameWarning']['Warning'] );
				}
				$clipData['ageGate'] = $this->getAgeGate( $clipData['industryRating'] );
				$clipData['ageRequired'] = $clipData['ageGate'];

				$clipData['genres'] = '';
				if ( !empty( $program['MovieCategory']['Category'] ) ) {
					$clipData['genres'] = $program['MovieCategory']['Category'];
				} else if ( !empty( $program['TvCategory']['Category'] ) ) {
					$clipData['genres'] = $program['TvCategory']['Category'];
				} else if ( !empty( $program['GameCategory']['Category'] ) ) {
					$clipData['genres'] = $program['GameCategory']['Category'];
				}

				$actors = array();
				if ( !empty( $program['ProgramToPerformerMaps']['results'] ) ) {
					foreach( $program['ProgramToPerformerMaps']['results'] as $performer ) {
						$actors[] = trim( $performer['Performer']['FullName'] );
					}
				}
				$clipData['actors'] = implode( ', ', $actors );

				$videoAssets = $program['VideoAssets']['results'];
				$numVideos = count( $videoAssets );
				print( "{$program['title']} (Series:{$clipData['series']}): Found $numVideos videos...\n" );

				// add video assets
				foreach ( $videoAssets as $videoAsset ) {
					$clipData['titleName'] = empty( $videoAsset['DisplayTitle'] ) ? trim( $videoAsset['Title'] ) : trim( $videoAsset['DisplayTitle'] );
					$clipData['videoId'] = $videoAsset['Publishedid'];

					if ( !empty( $videoAsset['ExpirationDate'] ) ) {
						print "Skip: {$clipData['titleName']} (Id:{$clipData['videoId']}) has expiration date.\n";
						continue;
					}

					$clipData['thumbnail'] = $videoAsset['VideoAssetScreenCapture']['URL'];
					$clipData['duration'] = $videoAsset['StreamLengthinseconds'];

					$clipData['published'] = '';
					if ( preg_match('/Date\((\d+)\)/', $videoAsset['DateCreated'], $matches) ) {
						$clipData['published'] = $matches[1]/1000;
					}

					$clipData['category'] = $this->mapCategory( trim( $videoAsset['MediaType']['Media'] ) );
					$clipData['description'] = trim( $videoAsset['Descriptions']['ItemDescription'] );
					$clipData['hd'] = ( $videoAsset['HdSource'] == 'true' ) ? 1 : 0;
					$clipData['provider'] = 'iva';

					$clipData['language'] = '';
					$clipData['subtitle'] = '';
					// $languageNames comes from cldr extension
					if ( !empty( $languageNames ) ) {
						// get language
						if ( !empty( $videoAsset['LanguageSpoken']['LanguageName'] ) ) {
							$lang = trim( $videoAsset['LanguageSpoken']['LanguageName'] );
							$clipData['language'] = array_search( $lang, $languageNames );
						}

						// get subtitle
						if ( !empty( $videoAsset['LanguageSubtitled']['LanguageName'] ) ) {
							$subtitle = trim( $videoAsset['LanguageSubtitled']['LanguageName'] );
							$clipData['subtitle'] = array_search( $subtitle, $languageNames );
						}
					}

					$clipData['targetCountry'] = '';
					// $countryNames comes from cldr extension
					if ( !empty( $countryNames ) && !empty( $videoAsset['CountryTarget']['CountryName'] ) ) {
						$targetCountry = trim( $videoAsset['CountryTarget']['CountryName'] );
						$clipData['targetCountry'] = array_search( $targetCountry, $countryNames );
					}

					$keywords = empty( $videoParams['keyword'] ) ? array() : array( $videoParams['keyword'] );
					$keywords[] = $clipData['series'];
					$keywords[] = $clipData['category'];

					// add to keywords to be used in page category
					if ( ( !empty( $clipData['language'] ) && $clipData['language'] != 'en' )
						|| ( !empty( $clipData['subtitle'] ) && $clipData['subtitle'] != 'en' ) ) {
						$keywords[] = 'Foreign';
					}

					$keywordsLower = array_map( 'strtolower', $keywords );
					$keywordsUniq = array_intersect_key( $keywords, array_unique( $keywordsLower ) );
					$clipData['keywords'] = implode( ', ', $keywordsUniq );

					$msg = '';
					$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
					if ( $msg ) {
						print "ERROR: $msg\n";
					}
				}

				// get videos for series (24), season (26)
				if ( !empty( $videoParams['isPublishedId'] )
					&& ( $program['MediaId'] == 24 || $program['MediaId'] == 26 ) ) {
					$params = $videoParams;
					$params['series'] = $clipData['series'];
					$params['season'] = $clipData['season'];
					$params['episode'] = $clipData['episode'];
					$params['videoSet'] = $program['Publishedid'];
					$params['isPromotesPublishedId'] = true;

					$result = $this->ingestVideos( $createParams, $startDate, $endDate, $params );
					if ( $result === false ) {
						wfProfileOut( __METHOD__ );
						return false;
					}

					$articlesCreated += $result;
				}
			}
		} while ( $numPrograms == self::API_PAGE_SIZE );

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * Create the feed URL for a specific $videoSet
	 * @param array $videoParams
	 * @param integer $startDate - Unixtime for beginning of modified-on date range
	 * @param integer $endDate - Unixtime for ending of modified-on date range
	 * @param integer $page - The page of results to fetch
	 * @return string - A feed URL
	 */
	private function makeSetFeedURL( $videoParams, $startDate, $endDate, $page ) {
		$filter = "(DateModified gt datetime'$startDate') " .
			"and (DateModified le datetime'$endDate') ";

		$videoSet = $videoParams['videoSet'];
		// check if it is PromotesPublishedId
		if ( empty( $videoParams['isPromotesPublishedId'] ) ) {
			// check if $videoSet is publish id or keyword
			if ( empty( $videoParams['isPublishedId'] ) ) {
				$filter .= "and (substringof('$videoSet', Title) eq true) ";
			} else {
				$filter .= "and (Publishedid eq $videoSet) ";
			}
		} else {
			$filter .= "and (PromotesPublishedId eq $videoSet) ";
		}

		// exclude song
		foreach ( self::$EXCLUDE_MEDIA_IDS as $id ) {
			$filter .= "and (MediaId ne $id) ";
		}

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
			'VideoAssets',
			'VideoAssets/Descriptions',
			'VideoAssets/VideoAssetScreenCapture',
			'VideoAssets/MediaType',
			'MovieMpaa',
			'TvRating',
			'GameWarning',
			'MovieCategory',
			'TvCategory',
			'ProgramToPerformerMaps/Performer',
			'VideoAssets/LanguageSpoken',
			'VideoAssets/LanguageSubtitled',
			'VideoAssets/CountryTarget',
		);

		$url = str_replace( '$4', implode( ',', $expand ), $url );
		$url = str_replace( '$5', F::app()->wg->IvaApiConfig['DeveloperId'], $url );

		return $url;
	}

	/**
	 * Call out to IVA for the video metadata from the URL passed as $url
	 * @param $url - The IVA URL to pull video metadata from
	 * @return array|bool
	 */
	private function requestData( $url ) {
		wfProfileIn( __METHOD__ );

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

		wfProfileOut( __METHOD__ );
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
			'subtitle'       => $data['subtitle'],
			'genres'         => $data['genres'],
			'actors'         => $data['actors'],
			'ageRequired'    => $data['ageRequired'],
			'targetCountry'  => $data['targetCountry'],
			'series'         => $data['series'],
			'season'         => $data['season'],
			'episode'        => $data['episode'],
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
