<?php

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

	const API_PAGE_SIZE = 100;

	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		include_once( dirname( __FILE__ ).'/../../../cldr/CldrNames/CldrNamesEn.php' );

		$debug = !empty($params['debug']);
		$startDate = !empty($params['startDate']) ? $params['startDate'] : '';
		$endDate = !empty($params['endDate']) ? $params['endDate'] : '';
		$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();
		$remoteAsset = !empty( $params['remoteAsset'] );

		$articlesCreated = 0;

		foreach( self::$VIDEO_SETS as $videoSet ) {
			$page = 0;
			do {
				// connect to provider API
				$url = $this->initFeedUrl( $videoSet, $startDate, $endDate, $page++ );
				print( "Connecting to $url...\n" );

				$req = MWHttpRequest::factory( $url );
				$status = $req->execute();
				if( $status->isOK() ) {
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
					$clipData['keywords'] = $videoSet;
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
						$clipData['industryRating'] = trim( $video['EntertainmentProgram']['MovieMpaa']['Rating'] );
					} else if ( !empty( $video['EntertainmentProgram']['TvRating']['Rating'] ) ) {
						$clipData['industryRating'] = trim( $video['EntertainmentProgram']['TvRating']['Rating'] );
					} else if ( !empty( $video['EntertainmentProgram']['GameWarning']['Warning'] ) ) {
						$clipData['industryRating'] = trim( $video['EntertainmentProgram']['GameWarning']['Warning'] );
					}

					$ageGateList = array( 'Extreme or graphic violence', 'Mature', 'Adults Only', 'TV-MA', 'NC-17', 'R' );
					$clipData['ageGate'] = in_array( $clipData['industryRating'], $ageGateList );

					$clipData['genres'] = '';
					if ( !empty( $video['EntertainmentProgram']['MovieCategory']['Category'] ) ) {
						$clipData['genres'] = $video['EntertainmentProgram']['MovieCategory']['Category'];
					} else if ( !empty( $video['EntertainmentProgram']['TvCategory']['Category'] ) ) {
						$clipData['genres'] = $video['EntertainmentProgram']['TvCategory']['Category'];
					} else if ( !empty( $video['EntertainmentProgram']['GameCategory']['Category'] ) ) {
						$clipData['genres'] = $video['EntertainmentProgram']['GameCategory']['Category'];
					}

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
			} while( $numVideos == self::API_PAGE_SIZE );
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	private function initFeedUrl( $videoSet, $startDate, $endDate, $page ) {
		$url = str_replace( '$1', self::API_PAGE_SIZE, static::$FEED_URL );
		$url = str_replace( '$2', self::API_PAGE_SIZE * $page, $url );

		$filter = '(DateModified gt datetime'."'$startDate'".') and (DateModified le datetime'."'$endDate'".') and (substringof('."'$videoSet'".', Title) eq true)';

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

	public function generateCategories( array $data, $addlCategories ) {
		wfProfileIn( __METHOD__ );

		$categories = !empty($addlCategories) ? $addlCategories : array();

		$categories[] = 'IVA';

		if ( !empty($data['keywords']) ) {
			$keywords = explode( ',', $data['keywords'] );

			foreach( $keywords as $keyword ) {
				$categories[] = trim( $keyword );
			}
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}

	protected function generateName( array $data ) {
		wfProfileIn( __METHOD__ );

		$name = $data['titleName'];

		wfProfileOut( __METHOD__ );

		return $name;
	}

	protected function generateMetadata( array $data, &$errorMsg ) {
		if ( empty($data['videoId']) ) {
			$errorMsg = 'no video id exists';
			return 0;
		}

		$metadata = array(
			'videoId' => $data['videoId'],
			'hd' => $data['hd'],
			'duration' => $data['duration'],
			'published' => $data['published'],
			'ageGate' => intval( $data['ageGate'] ),
			'thumbnail' => $data['thumbnail'],
			'category' => $data['category'],
			'description' => $data['description'],
			'keywords' => $data['keywords'],
			'tags' => $data['tags'],
			'industryRating' => $data['industryRating'],
			'provider' => $data['provider'],
			'language' => $data['language'],
			'genres' => $data['genres'],
			'actors' => $data['actors'],
		);

		return $metadata;
	}

	/**
	 * generate remote asset data
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
	 * generate hash
	 * @param string $url
	 * @return string $hash
	 */
	protected function generateHash( $url ) {
		$hash = md5( strtolower( F::app()->wg->IvaApiConfig['AppKey'].$url ) );

		return $hash;
	}
}