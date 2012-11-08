<?php

class RealgravityFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'RealgravityApiWrapper';
	protected static $PROVIDER = 'realgravity';
	protected static $FEED_URL = 'http://api.realgravity.com/v1/market_content/search.json?content_source_level=marketplace&video_catalog_id=$1&published_since=$2&page=$3&per_page=$4&api_key=$5';
	private static $API_MARKETPLACES = array(
		423 => array(
			'name' => 'LeGourmet TV',
			'categories' => array( 'Lifestyle', 'Le Gourmet' )
		),
		141 => array(
			'name' => 'HowCast',
			'categories' => array( 'HowTo', 'Lifestyle' )
		),
		202 => array(
			'name' => 'Howdini',
			'categories' => array( 'HowTo', 'Lifestyle' )
		),
		503 => array(
			'name' => 'Skee.TV',
			'categories' => array( 'Lifestyle' )
		),
		503 => array(
			'name' => 'Outside Lines Media',
			'categories' => array()
		),
		196 => array(
			'name' => 'VIDCAT Fashion TV',
			'categories' => array()
		),
	);

	const API_PAGE_SIZE = 100;

	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$numCreated = 0;

		foreach( self::$API_MARKETPLACES as $id => $info ) {
			$params['marketplaceId'] = $id;
			$params['marketplaceName'] = $info['name'];
			$params['extraCategories'] = $info['categories'];
			$numCreated += $this->importVideos( $params );
		}

		wfProfileOut( __METHOD__ );

		return $numCreated;
	}

	protected function importVideos( $params = array() ) {
		wfProfileIn( __METHOD__ );

		$addlCategories = ( !empty($params['addlCategories']) ) ? $params['addlCategories'] : array();
		if ( !empty($params['extraCategories']) ) {
			$addlCategories = array_merge( $addlCategories, $params['extraCategories'] );
		}
		$debug = ( !empty($params['debug']) );
		$startDate = ( !empty($params['startDate']) ) ? $params['startDate'] : '';
		$marketplaceId = ( !empty($params['marketplaceId']) ) ? $params['marketplaceId'] : '';

		$page = 1;
		$articlesCreated = 0;

		do {
			$numVideos = 0;

			// connect to provider API
			$url = $this->initFeedUrl( $marketplaceId, $startDate, $page++ );
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
			$videos = ( empty($response['contents']) ) ? array() : $response['contents'] ;

			$numVideos = count( $videos );
			print("Found $numVideos videos...\n");

			foreach( $videos as $video ) {
				$clipData = array();
				$clipData['titleName'] = trim($video['title']);
				$clipData['videoId'] = $video['id'];
				$clipData['altVideoId'] = $video['uuid'];
				$clipData['thumbnail'] = $video['thumbnail_url'];
				$clipData['duration'] = $video['duration'];
				$clipData['published'] = $video['published_at'];
				$clipData['category'] = $video['category']['name'];
				$clipData['keywords'] = $video['category']['name'];
				$clipData['description'] = trim($video['description']);
				$clipData['ageGate'] = 0;
				$clipData['hd'] = 0;
				$clipData['tags'] = $video['tag_list'];
				$clipData['provider'] = 'RealGravity';

				$clipData['marketplaceName'] = $video['video_catalog']['name'];
				$clipData['marketplaceId'] = $video['video_catalog']['id'];
				$clipData['categoryId'] = $video['category']['id'];

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

	private function initFeedUrl( $marketplaceId, $startDate, $page ) {
		global $wgRealgravityApiKey;

		$url = str_replace('$1', $marketplaceId, static::$FEED_URL);
		$url = str_replace('$2', $startDate, $url);
		$url = str_replace('$3', $page, $url);
		$url = str_replace('$4', self::API_PAGE_SIZE, $url);
		$url = str_replace('$5', $wgRealgravityApiKey, $url);

		return $url;
	}

	public function generateCategories( array $data, $addlCategories ) {
		wfProfileIn( __METHOD__ );

		$categories = ( !empty($addlCategories) ) ? $addlCategories : array();
		$categories[] = 'RealGravity';
		$categories[] = $data['marketplaceName'];

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
			'altVideoId' => $data['altVideoId'],
			'hd' => $data['hd'],
			'duration' => $data['duration'],
			'published' => strtotime($data['published']),
			'ageGate' => $data['ageGate'],
			'thumbnail' => $data['thumbnail'],
			'category' => $data['category'],
			'description' => $data['description'],
			'keywords' => $data['keywords'],
			'tags' => $data['tags'],
			'provider' => $data['provider'],
			'marketplaceId' => $data['marketplaceId'],
			'marketplaceName' => $data['marketplaceName'],
			'categoryId' => $data['categoryId'],
			);

		return $metadata;
	}

}