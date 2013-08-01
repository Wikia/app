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
		$articlesCreated = $this->importVideos( $content, $params );

		// by time restrictions
		$params['cond'] = array(
			"created_at < '$params[startDate]'",
			"time_restrictions.start_date >= '$params[startDate]'",
			"time_restrictions.start_date < '".gmdate( 'Y-m-d H:i:s', $params['now'] )."'",
		);
		$articlesCreated += $this->importVideos( $content, $params );

		return $articlesCreated;
	}

	public function importVideos( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$addlCategories = !empty($params['addlCategories']) ? $params['addlCategories'] : array();
		if ( !empty($params['extraCategories']) ) {
			$addlCategories = array_merge( $addlCategories, $params['extraCategories'] );
		}
		$debug = !empty($params['debug']);

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

			$videos = empty($response['items']) ? array() : $response['items'] ;
			$nextPage = empty($response['next_page']) ? '' : $response['next_page'] ;

			$numVideos = count( $videos );
			print("Found $numVideos videos...\n");

			foreach( $videos as $video ) {
				if ( !empty($video['time_restrictions']['start_date']) && strtotime($video['time_restrictions']['start_date']) > $params['now'] ) {
					continue;
				}

				$clipData = array();
				$clipData['titleName'] = trim($video['name']);
				$clipData['videoId'] = $video['embed_code'];
				$clipData['thumbnail'] = $video['preview_image_url'];
				$clipData['duration'] = $video['duration'] / 1000;
				$clipData['published'] = empty($video['metadata']['published']) ? '' : $video['metadata']['published'];
				$clipData['name'] = empty($video['metadata']['name']) ? '' : $video['metadata']['name'];
				$clipData['type'] = empty($video['metadata']['type']) ? '' : $video['metadata']['type'];
				$clipData['category'] = empty($video['metadata']['category']) ? '' : $video['metadata']['category'];
				$clipData['keywords'] = empty($video['metadata']['keywords']) ? '' : $video['metadata']['keywords'];
				$clipData['description'] = trim($video['description']);
				$clipData['ageRequired'] = empty( $video['metadata']['age_required'] ) ? 0 : $video['metadata']['age_required'];
				$clipData['hd'] = empty($video['metadata']['hd']) ? 0 : 1;
				$clipData['tags'] = empty($video['metadata']['tags']) ? '' : $video['metadata']['tags'];
				$clipData['industryRating'] = empty($video['metadata']['industryrating']) ? '' : $video['metadata']['industryrating'];
				$clipData['trailerRating'] = empty($video['metadata']['trailerrating']) ? '' : $video['metadata']['trailerrating'];

				$clipData['categoryName'] = OoyalaApiWrapper::getProviderName( $video['labels'] );
				// check for videos under '/Providers/' labels
				if ( empty($clipData['categoryName']) ) {
					print "Skipping {$clipData['titleName']} - {$clipData['description']}. No provider name.\n";
					continue;
				}
				$clipData['provider'] = OoyalaApiWrapper::formatProviderName( $clipData['categoryName'] );

				$clipData['language'] =  empty($video['metadata']['lang']) ? '' : $video['metadata']['lang'];
				$clipData['subtitle'] =  empty( $video['metadata']['subtitle'] ) ? '' : $video['metadata']['subtitle'];
				$clipData['genres'] = empty($video['metadata']['genres']) ? '' : $video['metadata']['genres'];
				$clipData['actors'] = empty($video['metadata']['actors']) ? '' : $video['metadata']['actors'];
				$clipData['startDate'] = empty($video['time_restrictions']['start_date']) ? '' : $video['time_restrictions']['start_date'];
				$clipData['expirationDate'] = empty($video['metadata']['expirationdate']) ? '' : $video['metadata']['expirationdate'];
				$clipData['playerId'] = OoyalaApiWrapper::getPlayerId( $clipData['videoId'] );
				$clipData['targetCountry'] = empty( $video['metadata']['targetcountry'] ) ? '' : $video['metadata']['targetcountry'];
				$clipData['source'] = empty( $video['metadata']['source'] ) ? '' : $video['metadata']['source'];
				$clipData['sourceId'] = empty( $video['metadata']['sourceid'] ) ? '' : $video['metadata']['sourceid'];
				$clipData['series'] = empty( $video['metadata']['series'] ) ? '' : $video['metadata']['series'];
				$clipData['season'] = empty( $video['metadata']['season'] ) ? '' : $video['metadata']['season'];
				$clipData['episode'] = empty( $video['metadata']['episode'] ) ? '' : $video['metadata']['episode'];
				$clipData['characters'] = empty( $video['metadata']['characters'] ) ? '' : $video['metadata']['characters'];
				$clipData['pageCategories'] = empty($video['metadata']['pageCategories']) ? '' : $video['metadata']['pageCategories'];

				$msg = '';
				$createParams = array( 'addlCategories' => $addlCategories, 'debug' => $debug, 'provider' => $clipData['provider'] );
				$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
				if ( $msg ) {
					print "ERROR: $msg\n";
				}
			}
		} while( !empty($nextPage) );

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

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


	public function generateCategories(array $data, $addlCategories) {
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

		if ( !in_array( 'Ooyala', $categories) ) {
			$categories[] = 'Ooyala';
		}

		wfProfileOut( __METHOD__ );

		return $categories;
	}

	protected function generateMetadata( array $data, &$errorMsg ) {
		if ( empty( $data['videoId'] ) ) {
			$errorMsg = 'no video id exists';
			return 0;
		}

		$metadata = array(
			'videoId'        => $data['videoId'],
			'hd'             => $data['hd'],
			'duration'       => $data['duration'],
			'published'      => empty( $data['published'] ) ? $data['published'] : strtotime( $data['published'] ),
			'ageRequired'    => $data['ageRequired'],
			'industryRating' => $data['industryRating'],
			'trailerRating'  => $data['trailerRating'],
			'thumbnail'      => $data['thumbnail'],
			'category'       => $data['category'],
			'description'    => $data['description'],
			'keywords'       => $data['keywords'],
			'tags'           => $data['tags'],
			'provider'       => $data['provider'],
			'language'       => $data['language'],
			'subtitle'       => $data['subtitle'],
			'genres'         => $data['genres'],
			'actors'         => $data['actors'],
			'startDate'      => empty( $data['startDate'] ) ? $data['startDate'] : strtotime( $data['startDate'] ),
			'expirationDate' => empty( $data['expirationDate'] ) ? $data['expirationDate'] : strtotime( $data['expirationDate'] ),
			'playerId'       => $data['playerId'],
			'targetCountry'  => $data['targetCountry'],
			'source'         => $data['source'],
			'sourceId'       => $data['sourceId'],
			'series'         => $data['series'],
			'season'         => $data['season'],
			'episode'        => $data['episode'],
			'name'           => $data['name'],
			'type'           => $data['type'],
			'characters'     => $data['characters'],
			'pageCategories' => $data['pageCategories'],
		);

		return $metadata;
	}

}