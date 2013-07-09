<?php

/**
 * Class IvaFeedIngester
 */
class IvaFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'IvaApiWrapper';
	protected static $PROVIDER = 'iva';
	protected static $FEED_URL = 'http://api.internetvideoarchive.com/1.0/DataService/VideoAssets?$top=$1&$skip=$2&$filter=$3&$expand=$4&$format=json&developerid=$5';
	protected static $ASSET_URL = 'http://www.videodetective.net/video.mp4?cmd=6&fmt=4&customerid=$1&videokbrate=750&publishedid=$2&e=$3';

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

		$articlesCreated = 0;

		$page = 0;
		do {
			// connect to provider API
			$url = $this->initFeedUrl( $startDate, $endDate, $page++ );
			print( "Connecting to $url...\n" );

			$req = MWHttpRequest::factory( $url );
			$status = $req->execute();
			if ( $status->isOK() ) {
				$response = $req->getContent();
			} else {
				print( "ERROR: problem downloading content.\n" );
				wfProfileOut( __METHOD__ );

				return 0;
			}

			// parse response
			$response = json_decode( $response, true );
			$videos = ( empty($response['d']['results']) ) ? array() : $response['d']['results'] ;
			$numVideos = count( $videos );

			print( "Found $numVideos videos...\n" );

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
				$keywords = array( );
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
				$createParams = array( 'addlCategories' => $addlCategories, 'debug' => $debug, 'remoteAsset' => $remoteAsset );
				$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
				if ( $msg ) {
					print "ERROR: $msg\n";
				}
			}
		} while ( $numVideos == self::API_PAGE_SIZE );

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * Construct the URL given a start and end date and the result page to retrieve.
	 * @param $startDate
	 * @param $endDate
	 * @param $page
	 * @return mixed
	 */
	private function initFeedUrl( $startDate, $endDate, $page ) {
		$url = str_replace( '$1', self::API_PAGE_SIZE, static::$FEED_URL );
		$url = str_replace( '$2', self::API_PAGE_SIZE * $page, $url );

		$filter = "(DateModified gt datetime'$startDate') " .
		      "and (DateModified le datetime'$endDate')";

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