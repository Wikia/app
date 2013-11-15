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
		647 => array(
			'name' => 'Howcast - Cars and Transportation',
			'categories' => array( 'HowTo', 'HowCast', 'Lifestyle', 'Cars', 'Transportation' )
		),
		648 => array(
			'name' => 'Howcast - Crafts and Hobbies',
			'categories' => array( 'HowTo', 'HowCast', 'Lifestyle', 'Crafts', 'Hobbies' )
		),
		649 => array(
			'name' => 'Howcast - Food and Drink',
			'categories' => array( 'HowTo', 'HowCast', 'Lifestyle', 'Food', 'Drink' )
		),
		650 => array(
			'name' => 'Howcast - Health and Nutrition',
			'categories' => array( 'HowTo', 'HowCast', 'Lifestyle', 'Health', 'Nutrition' )
		),
		651 => array(
			'name' => 'Howcast - Parenting and Family',
			'categories' => array( 'HowTo', 'HowCast', 'Lifestyle', 'Parenting', 'Family' )
		),
		652 => array(
			'name' => 'Howcast - Personal Care and Style',
			'categories' => array( 'HowTo', 'HowCast', 'Lifestyle', 'Personal Care', 'Style' )
		),
		655 => array(
			'name' => 'Howcast - Sports and Fitness',
			'categories' => array( 'HowTo', 'HowCast', 'Lifestyle', 'Sports', 'Fitness' )
		),
		202 => array(
			'name' => 'Howdini',
			'categories' => array( 'HowTo', 'Lifestyle' )
		),
		503 => array(
			'name' => 'Skee.TV',
			'categories' => array( 'Lifestyle' )
		),
		419 => array(
			'name' => 'Outside Lines Travel',
			'categories' => array()
		),
		196 => array(
			'name' => 'VIDCAT Fashion TV',
			'categories' => array()
		),
		586 => array(
			'name' => 'Billboard',
			'categories' => array()
		),
		628 => array(
			'name' => 'Sugar Inc. - FitSugar',
			'categories' => array( 'Health & fitness' )
		),
		629 => array(
			'name' => 'Sugar Inc. - FabSugar',
			'categories' => array( 'Fashion' )
		),
		630 => array(
			'name' => 'Sugar Inc. - BellaSugar',
			'categories' => array( 'Beauty' )
		),
		631 => array(
			'name' => 'Sugar Inc. - YumSugar',
			'categories' => array( 'Food' )
		),
	);

	const API_PAGE_SIZE = 100;

	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$numCreated = 0;

		foreach ( self::$API_MARKETPLACES as $id => $info ) {
			$params['marketplaceId'] = $id;
			$params['marketplaceName'] = $info['name'];
			$params['extraCategories'] = $info['categories'];
			$numCreated += $this->importVideos( $params );
		}

		wfProfileOut( __METHOD__ );

		return $numCreated;
	}

	/**
	 * import videos
	 * @param array $params
	 * @return integer $articlesCreated
	 */
	protected function importVideos( $params = array() ) {
		wfProfileIn( __METHOD__ );

		$addlCategories = empty( $params['addlCategories'] ) ? array() : $params['addlCategories'];
		if ( !empty( $params['extraCategories'] ) ) {
			$addlCategories = array_merge( $addlCategories, $params['extraCategories'] );
		}
		$debug = !empty( $params['debug'] );
		$startDate = empty( $params['startDate'] ) ? '' : $params['startDate'];
		$marketplaceId = empty( $params['marketplaceId'] ) ? '' : $params['marketplaceId'];

		$page = 1;
		$articlesCreated = 0;

		do {
			$numVideos = 0;

			// connect to provider API
			$url = $this->initFeedUrl( $marketplaceId, $startDate, $page++ );
			print( "Connecting to $url...\n" );

			$req = MWHttpRequest::factory( $url );
			$status = VideoHandlerHelper::wrapHttpRequest( $req );
			if( $status->isOK() ) {
				$response = $req->getContent();
			} else {
				print( "ERROR: problem downloading content.\n" );
				wfProfileOut( __METHOD__ );

				return 0;
			}

			// parse response
			$response = json_decode( $response, true );
			$videos = empty( $response['contents'] ) ? array() : $response['contents'] ;

			$numVideos = count( $videos );
			print("Found $numVideos videos...\n");

			foreach( $videos as $video ) {
				$clipData = array();
				$clipData['titleName'] = trim( $video['title'] );
				$clipData['videoId'] = $video['id'];
				$clipData['altVideoId'] = $video['uuid'];
				$clipData['thumbnail'] = $video['thumbnail_url'];
				$clipData['duration'] = $video['duration'];
				$clipData['published'] = strtotime( $video['published_at'] );
				$clipData['category'] = $this->getCategory( $video['category']['name'] );
				$clipData['genres'] = $this->getStdGenre( $video['category']['name'] );
				$clipData['description'] = trim( $video['description'] );
				$clipData['ageRequired'] = 0;
				$clipData['ageGate'] = 0;
				$clipData['hd'] = 0;
				$clipData['keywords'] = preg_replace( '/,([^\s])/', ', $1', $video['tag_list'] );
				$clipData['provider'] = 'realgravity';

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

	/**
	 * get feed url
	 * @param integer $marketplaceId
	 * @param string $startDate
	 * @param string $page
	 * @return string $url
	 */
	private function initFeedUrl( $marketplaceId, $startDate, $page ) {
		global $wgRealgravityApiKey;

		$url = str_replace( '$1', $marketplaceId, static::$FEED_URL );
		$url = str_replace( '$2', $startDate, $url );
		$url = str_replace( '$3', $page, $url );
		$url = str_replace( '$4', self::API_PAGE_SIZE, $url );
		$url = str_replace( '$5', $wgRealgravityApiKey, $url );

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

		$categories[] = 'RealGravity';
		$categories[] = $data['marketplaceName'];

		wfProfileOut( __METHOD__ );

		return $categories;
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

		$metadata['marketplaceId'] = empty( $data['marketplaceId'] ) ? '' : $data['marketplaceId'];
		$metadata['marketplaceName'] = empty( $data['marketplaceName'] ) ? '' : $data['marketplaceName'];
		$metadata['categoryId'] = empty( $data['categoryId'] ) ? '' : $data['categoryId'];

		return $metadata;
	}

}