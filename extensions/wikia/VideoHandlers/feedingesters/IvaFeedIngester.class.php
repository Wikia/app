<?php

class IvaFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'IvaApiWrapper';
	protected static $PROVIDER = 'iva';
	protected static $FEED_URL = 'http://api.internetvideoarchive.com/1.0/DataService/VideoAssets?$top=$1&$skip=$2&$filter=$3&$expand=$4&$format=json&developerid=$5';
	private static $VIDEO_SETS = array(
		'glee',
	);

	const API_PAGE_SIZE = 100;

	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$debug = !empty($params['debug']);
		$startDate = !empty($params['startDate']) ? $params['startDate'] : '';
		$endDate = !empty($params['endDate']) ? $params['endDate'] : '';
		$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();

		$page = 0;
		$articlesCreated = 0;

		do {
			$numVideos = 0;

			// connect to provider API
			$url = $this->initFeedUrl( $startDate, $endDate, $page++ );
			print("Connecting to $url...\n");

			$req = MWHttpRequest::factory( $url );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
			} else {
				print("ERROR: problem downloading content.\n");
				wfProfileOut( __METHOD__ );

				return 0;
			}

			// parse response
			$response = json_decode( $response, true );
			$videos = ( empty($response['d']['results']) ) ? array() : $response['d']['results'] ;
			$numVideos = count( $videos );
			print("Found $numVideos videos...\n");

			foreach( $videos as $video ) {
				$clipData = array();
				$clipData['titleName'] =  empty($video['DisplayTitle']) ? trim( $video['Title'] ) : trim( $video['DisplayTitle'] );
				$clipData['videoId'] = $video['Publishedid'];

				if ( !empty($video['ExpirationDate']) ) {
					print "Skipping {$clipData['titleName']} (Id:{$clipData['videoId']}) has expiration date.\n";
					continue;
				}

				if ( !empty($video['TargetCountryId']) && $video['TargetCountryId'] != -1 ) {
					print "Skipping {$clipData['titleName']} (Id:{$clipData['videoId']}) has regional restrictions.\n";
					continue;
				}

				$clipData['thumbnail'] = $video['VideoAssetScreenCapture']['URL'];
				$clipData['duration'] = $video['StreamLengthinseconds'];

				$clipData['published'] = '';
				if ( preg_match('/Date\((\d+)\)/', $video['DateCreated'], $matches) ) {
					$clipData['published'] = $matches[1]/1000;
				}

				$clipData['category'] = $video['MediaType']['Media'];
				$clipData['keywords'] = '';
				$clipData['description'] = trim($video['Descriptions']['ItemDescription']);
				$clipData['ageGate'] = 0;
				$clipData['hd'] = ( $video['HdSource'] == 'true' ) ? 1 : 0;
				$clipData['tags'] = $video['EntertainmentProgram']['Tagline'];
				$clipData['provider'] = 'iva';

				$clipData['industryRating'] = '';
				if ( !empty($video['EntertainmentProgram']['MovieMpaa']['Rating']) ) {
					$clipData['industryRating'] = $video['EntertainmentProgram']['MovieMpaa']['Rating'];
				} else if ( !empty($video['EntertainmentProgram']['TvRating']['Rating']) ) {
					$clipData['industryRating'] = $video['EntertainmentProgram']['TvRating']['Rating'];
				}

				$clipData['genres'] = '';
				if ( !empty($video['EntertainmentProgram']['MovieCategory']['Category']) ) {
					$clipData['genres'] = $video['EntertainmentProgram']['MovieCategory']['Category'];
				} else if ( !empty($video['EntertainmentProgram']['TvCategory']['Category']) ) {
					$clipData['genres'] = $video['EntertainmentProgram']['TvCategory']['Category'];
				}

				$actors = array();
				if ( !empty($video['EntertainmentProgram']['ProgramToPerformerMaps']['results']) ) {
					foreach( $video['EntertainmentProgram']['ProgramToPerformerMaps']['results'] as $performer ) {
						$actors[] = $performer['Performer']['FullName'];
					}
				}
				$clipData['actors'] = implode( ', ', $actors );

				$msg = '';
				$createParams = array( 'addlCategories' => $addlCategories, 'debug' => $debug );
				$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
				if ( $msg ) {
					print "ERROR: $msg\n";
				}
			}
		} while( $numVideos == self::API_PAGE_SIZE );

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	private function initFeedUrl( $startDate, $endDate, $page ) {
		global $wgIvaApiConfig;

		$url = str_replace( '$1', self::API_PAGE_SIZE, static::$FEED_URL );
		$url = str_replace( '$2', self::API_PAGE_SIZE * $page, $url );

		$filter = '(DateModified gt datetime'."'$startDate'".') and (DateModified le datetime'."'$endDate'".') and ((MediaId eq 24) or (MediaId eq 25) or (MediaId eq 26) or (MediaId eq 27))';
		foreach( self::$VIDEO_SETS as $videoSet ) {
			$filter .= " and (substringof('$videoSet', Title) eq true)";
		}

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
		);
		$url = str_replace( '$4', implode( ',', $expand ), $url );

		$url = str_replace( '$5', $wgIvaApiConfig['DeveloperId'], $url );

		return $url;
	}

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
			'ageGate' => $data['ageGate'],
			'thumbnail' => $data['thumbnail'],
			'category' => $data['category'],
			'description' => $data['description'],
			'keywords' => $data['keywords'],
			'tags' => $data['tags'],
			'provider' => $data['provider'],
			'genres' => $data['genres'],
			'actors' => $data['actors'],
		);

		return $metadata;
	}

}