<?php

class OoyalaFeedIngester extends VideoFeedIngester {
	const API_PAGE_SIZE = 100;

	protected static $API_WRAPPER = 'OoyalaApiWrapper';
	protected static $PROVIDER = 'ooyala';
	protected static $FEED_URL = 'https://api.ooyala.com';

	public function import( $content = '', $params = array() ) {
		$params['now'] = time();

		// by created date
		$params['cond'] = array(
			"created_at >= '$params[startDate]'",
			"created_at < '$params[endDate]'",
		);
		$articlesCreated = $this->importVideos( $params );

		// by time restrictions
		$params['cond'] = array(
			"created_at < '$params[startDate]'",
			"time_restrictions.start_date >= '$params[startDate]'",
			"time_restrictions.start_date < '".gmdate( 'Y-m-d H:i:s', $params['now'] )."'",
		);
		$articlesCreated += $this->importVideos( $params );

		return $articlesCreated;
	}

	/**
	 * import videos
	 * @param array $params
	 * @return integer $articlesCreated
	 */
	public function importVideos( $params = array() ) {
		wfProfileIn( __METHOD__ );

		$addlCategories = empty( $params['addlCategories'] ) ? array() : $params['addlCategories'];
		$debug = !empty( $params['debug'] );

		$articlesCreated = 0;
		$nextPage = '';

		// ingest only live video
		$cond = array_merge( array( "status = 'live'" ), $params['cond'] );

		$apiParams = array(
			'limit' => self::API_PAGE_SIZE,
			'where' => implode( ' AND ', $cond ),
		);

		do {
			$numVideos = 0;

			// connect to provider API
			$url = $this->initFeedUrl( $apiParams, $nextPage );
			print( "Connecting to $url...\n" );

			$req = MWHttpRequest::factory( $url );
			$status = $req->execute();
			if ( $status->isGood() ) {
				$response = $req->getContent();
			} else {
				print( "ERROR: problem downloading content (".$status->getMessage().").\n" );
				wfProfileOut( __METHOD__ );

				return 0;
			}

			// parse response
			$response = json_decode( $response, true );

			$videos = empty( $response['items'] ) ? array() : $response['items'] ;
			$nextPage = empty( $response['next_page'] ) ? '' : $response['next_page'] ;

			$numVideos = count( $videos );
			print( "Found $numVideos videos...\n" );

			foreach ( $videos as $video ) {
				if ( !empty( $video['time_restrictions']['start_date'] ) && strtotime( $video['time_restrictions']['start_date'] ) > $params['now'] ) {
					continue;
				}

				$clipData = array();
				$clipData['titleName'] = trim( $video['name'] );
				$clipData['videoId'] = $video['embed_code'];
				$clipData['thumbnail'] = $video['preview_image_url'];
				$clipData['duration'] = $video['duration'] / 1000;
				$clipData['published'] = empty( $video['metadata']['published'] ) ? '' : strtotime( $video['metadata']['published'] );
				$clipData['name'] = empty( $video['metadata']['name'] ) ? '' : $video['metadata']['name'];
				$clipData['type'] = empty( $video['metadata']['type'] ) ? '' : $video['metadata']['type'];
				$clipData['category'] = empty( $video['metadata']['category'] ) ? '' : $video['metadata']['category'];
				$clipData['keywords'] = empty( $video['metadata']['keywords'] ) ? '' : $video['metadata']['keywords'];
				$clipData['description'] = trim( $video['description'] );

				$clipData['ageRequired'] = empty( $video['metadata']['age_required'] ) ? 0 : $video['metadata']['age_required'];
				$clipData['ageGate'] = empty( $clipData['ageRequired'] ) ? 0 : 1;

				$clipData['hd'] = empty( $video['metadata']['hd'] ) ? 0 : 1;

				$clipData['industryRating'] = '';
				if ( !empty( $video['metadata']['industryrating'] ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $video['metadata']['industryrating'] );
				}

				$clipData['categoryName'] = OoyalaApiWrapper::getProviderName( $video['labels'] );
				// check for videos under '/Providers/' labels
				if ( empty( $clipData['categoryName'] ) ) {
					print "Skipping {$clipData['titleName']} - {$clipData['description']}. No provider name.\n";
					continue;
				}
				$clipData['provider'] = OoyalaApiWrapper::formatProviderName( $clipData['categoryName'] );

				$clipData['language'] =  empty( $video['metadata']['lang'] ) ? '' : $video['metadata']['lang'];
				$clipData['subtitle'] =  empty( $video['metadata']['subtitle'] ) ? '' : $video['metadata']['subtitle'];
				$clipData['genres'] = empty( $video['metadata']['genres'] ) ? '' : $video['metadata']['genres'];
				$clipData['actors'] = empty( $video['metadata']['actors'] ) ? '' : $video['metadata']['actors'];
				$clipData['startDate'] = empty( $video['time_restrictions']['start_date'] ) ? '' : strtotime( $video['time_restrictions']['start_date'] );
				$clipData['expirationDate'] = empty( $video['metadata']['expirationdate'] ) ? '' : strtotime( $video['metadata']['expirationdate'] );
				$clipData['targetCountry'] = empty( $video['metadata']['targetcountry'] ) ? '' : $video['metadata']['targetcountry'];
				$clipData['source'] = empty( $video['metadata']['source'] ) ? '' : $video['metadata']['source'];
				$clipData['sourceId'] = empty( $video['metadata']['sourceid'] ) ? '' : $video['metadata']['sourceid'];
				$clipData['series'] = empty( $video['metadata']['series'] ) ? '' : $video['metadata']['series'];
				$clipData['season'] = empty( $video['metadata']['season'] ) ? '' : $video['metadata']['season'];
				$clipData['episode'] = empty( $video['metadata']['episode'] ) ? '' : $video['metadata']['episode'];
				$clipData['characters'] = empty( $video['metadata']['characters'] ) ? '' : $video['metadata']['characters'];
				$clipData['resolution'] = empty( $video['metadata']['resolution'] ) ? '' : $video['metadata']['resolution'];
				$clipData['aspectRatio'] = empty( $video['metadata']['aspectratio'] ) ? '' : $video['metadata']['aspectratio'];

				// For page categories only. Not store in metadata.
				$clipData['pageCategories'] = empty( $video['metadata']['pagecategories'] ) ? '' : $video['metadata']['pagecategories'];

				$msg = '';
				$createParams = array( 'addlCategories' => $addlCategories, 'debug' => $debug, 'provider' => $clipData['provider'] );
				$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
				if ( $msg ) {
					print "ERROR: $msg\n";
				}
			}
		} while ( !empty( $nextPage ) );

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * get feed url
	 * @param array $params
	 * @param string $nextPage
	 * @return string $url
	 */
	private function initFeedUrl( $params, $nextPage ) {
		$method = 'GET';
		$reqPath = '/v2/assets';
		if ( !empty($nextPage) ) {
			$parsed = explode( "?", $nextPage );
			parse_str( array_pop($parsed), $params );
		}

		$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );

		return $url;
	}


	/**
	 * Create list of category names to add to the new file page
	 * @param array $data
	 * @param array $categories
	 * @return array $categories
	 */
	public function generateCategories( $data, $categories ) {
		wfProfileIn( __METHOD__ );

		if ( !empty( $data['name'] ) ) {
			$categories += array_map( 'trim', explode( ',', $data['name'] ) );
		}

		if ( !empty( $data['pageCategories'] ) ) {
			$categories += array_map( 'trim', explode( ',', $data['pageCategories'] ) );
		}

		// remove 'the' category
		$key = array_search( 'the', array_map( 'strtolower', $categories ) );
		if ( $key !== false ) {
			unset( $categories[$key] );
		}

		if ( !empty( $data['categoryName'] ) ) {
			$categories[] = $data['categoryName'];
		}

		$categories[] = 'Ooyala';

		wfProfileOut( __METHOD__ );

		return $this->getUniqueArray( $categories );
	}

	/**
	 * generate meatadata
	 * @param array $data
	 * @param string $errorMsg
	 * @return array|integer $metadata or zero on error
	 */
	public function generateMetadata( $data, &$errorMsg ) {
		$metadata = parent::generateMetadata( $data, $errorMsg );
		if ( empty( $metadata ) ) {
			return 0;
		}

		$metadata['startDate'] = empty( $data['startDate'] ) ? '' :  $data['startDate'];
		$metadata['source'] = empty( $data['source'] ) ? '' :  $data['source'];
		$metadata['sourceId'] = empty( $data['sourceId'] ) ? '' :  $data['sourceId'];
		$metadata['pageCategories'] = empty( $data['pageCategories'] ) ? '' :  $data['pageCategories'];

		return $metadata;
	}

}