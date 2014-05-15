<?php

class MixedFeedModel extends WikiaModel {
	const GA_ACCOUNT = 62731403;
	const MIN_IMAGE_SIZE = 200;
	const DAY_QUARTER = 21600;
	const FAKE_HUB_GAMEOFTHRONES = -1;
	const FAKE_HUB_ELDERSCROLLS = -2;
	const FAKE_HUB_MARVEL = -3;
	private $ga;
	private $quarter;

	/**
	 * @param mixed $quarter
	 */
	public function setQuarter( $quarter ) {
		$this->quarter = $quarter;
	}

	/**
	 * @return mixed
	 */
	public function getQuarter() {
		return $this->quarter;
	}

	private function initGA() {
		global $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy;
		try {
			$this->ga = new gapi( $wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy );
		} catch ( Exception $e ) {
			$this->ga = false;
		}
	}

	public function __construct() {
		parent::__construct();
		$this->initGA();
		$this->setQuarter( $this->computeDayQuarter() );

	}

	public function getLastPagesByViewsGA( $hostName, $dateMin = null, $dateMax = null, $startIndex = 1, $limit = 10 ) {
		if ( !$this->ga ) {
			return [ ];
		}
		if ( $dateMax === null ) {
			$dateMax = date( 'Y-m-d', strtotime( 'now - 1day' ) );
			if ( $dateMin === null ) {
				$dateMin = date( 'Y-m-d', strtotime( 'now - 2day' ) );
			}
		}
		try {
			$this->ga->requestReportData( self::GA_ACCOUNT,
				[ 'pagePath' ],
				[ 'pageviews' ], '-pageviews', 'hostname == ' . $hostName, $dateMin, $dateMax, $startIndex, $limit );
			$results = $this->ga->getResults();
		} catch ( Exception $e ) {
			return [ ];
		}
		$data = [ ];
		foreach ( $results as $result ) {
			$dim = $result->getDimesions();
			$data[ ] = $dim[ 'pagePath' ];
		}
		return $data;

	}

	public function computeDayQuarter() {
		$seconds = time() - strtotime( "today" );
		return ceil( $seconds / self::DAY_QUARTER );
	}

	public function GOTWikiaData() {
		$limits = [ 'gameofthrones.wikia.com' => 5, 'iceandfire.wikia.com' => 3 ];
		$data = $this->queryGA( $limits );
		$feedModel = new \Wikia\Search\Services\FeedEntitySearchService();
		$feedModel->setQuality( 80 );
		$feedModel->setHubs( [ 'Entertainment' ] );
		$feedModel->setLang( 'en' );
		$feedModel->setUrls( $data );
		$rows = $feedModel->query( '' );
		$rows = $this->filterRows( $rows, $limits, $data );
		return $rows;
	}

	public function ESWikiaData() {
		$limits = [ 'elderscrolls.wikia.com' => 4, 'tesfanon.wikia.com' => 2, 'tes-mods.wikia.com' => 2 ];
		$data = $this->queryGA( $limits );
		$feedModel = new \Wikia\Search\Services\FeedEntitySearchService();
		$feedModel->setQuality( 80 );
		$feedModel->setLang( 'en' );
		$feedModel->setUrls( $data );
		$rows = $feedModel->query( '' );
		$rows = $this->filterRows( $rows, $limits, $data );

		return $rows;
	}

	public function MarvelWikiaData() {
		$limits = [ 'marvel.wikia.com' => 8 ];
		$data = $this->queryGA( $limits );
		$feedModel = new \Wikia\Search\Services\FeedEntitySearchService();
		$feedModel->setQuality( 80 );
		$feedModel->setLang( 'en' );
		$feedModel->setUrls( $data );
		$rows = $feedModel->query( '' );
		$rows = $this->filterRows( $rows, $limits, $data );

		return $rows;
	}

	private function queryGA( $limits ) {
		$data = [ ];
		foreach ( $limits as $host => $limit ) {
			$limitMax = $limit * 2;
			$data = array_merge( $data, $this->getLastPagesByViewsGA( $host, null, null, $this->getStartIndex( $limitMax ), $limitMax ) );
		}
		return $data;
	}

	private function getStartIndex( $limit ) {
		return ( ( $this->quarter - 1 ) * $limit ) + 1;
	}

	private function filterRows( $rows, $limits, $originalData ) {
		$tmpData = [ ];
		foreach ( $rows as $key => $item ) {
			$tmpData[ $item[ 'url' ] ] = $item;
		}
		$outputData = [ ];
		foreach ( $originalData as $url ) {
			$url = 'http://' . $url;
			if ( !isset( $tmpData[ $url ] ) ) {
				continue;
			}
			$item = $tmpData[ $url ];
			$host = $item[ 'host' ];
			if ( $limits[ $host ] > 0 ) {
				$limits[ $host ]--;
				$outputData[ ] = $item;
			}
		}
		return $outputData;
	}

	public function getArticleThumbnail( $host, $wikiId, $articleId ) {
		$url = sprintf( 'http://%s/api/v1/Articles/Details?ids=%u', $host, $articleId );
		$res = Http::get( $url );
		$res = json_decode( $res, true );
		$article = $res[ 'items' ][ $articleId ];
		if ( !$article[ 'thumbnail' ] ) {
			$ws = new WikiService();
			$article[ 'thumbnail' ] = $ws->getWikiWordmark( $wikiId );
		}
		return [
			'url' => $article[ 'thumbnail' ],
			'width' => $article[ 'original_dimensions' ][ 'width' ] < self::MIN_IMAGE_SIZE ? self::MIN_IMAGE_SIZE : $article[ 'original_dimensions' ][ 'width' ],
			'height' => $article[ 'original_dimensions' ][ 'height' ] < self::MIN_IMAGE_SIZE ? self::MIN_IMAGE_SIZE : $article[ 'original_dimensions' ][ 'width' ]
		];
	}

	public function getArticleDescription( $host, $articleId ) {
		$url = sprintf( 'http://%s/api/v1/Articles/AsSimpleJson?id=%u', $host, $articleId );
		$res = Http::get( $url );
		$res = json_decode( $res, true );
		//var_dump($res);
		foreach ( $res[ 'sections' ] as $section ) {
			if ( is_array( $section[ 'content' ] ) ) {
				foreach ( $section[ 'content' ] as $content ) {
					if ( $content[ 'type' ] === 'paragraph' ) {
						return $content[ 'text' ];
					}
				}
			}
		}

	}


}