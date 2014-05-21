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
	public function getLastPagesByDeltaContent($wikiId, $dateMin = null, $dateMax = null){
		if ( $dateMax === null ) {
			$dateMax = date( 'Y-m-d', strtotime( 'now - 1day' ) );
			if ( $dateMin === null ) {
				$dateMin = date( 'Y-m-d', strtotime( 'now - 2day' ) );
			}
		}
		$dateMax = preg_replace('/[^0-9]+/','',$dateMax).'000000';
		$dateMin = preg_replace('/[^0-9]+/','',$dateMin).'000000';
		$wikiId = (int)$wikiId;
		$query =
			"a.rev_page, max(a.rev_len) - min(a.rev_len) as xdiff from revision a, page p where  a.rev_timestamp>= '".$dateMin."'
				and   a.rev_timestamp<= '".$dateMax."'
                and p.page_id=a.rev_page and p.page_namespace=0  group by 1 having xdiff > 0 order by  2 desc limit 20  ";

		$db = wfGetDB( DB_SLAVE, array(), WikiFactory::IDtoDB($wikiId) );
		$wikisData = ( new WikiaSQL() )
			->SELECT( $query )
			->runLoop( $db, function (&$wikisData, $row ) use ($wikiId) {
				$wikisData[] = $wikiId.'_'. $row->rev_page ;

			} );

		return $wikisData;
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


	public function fromHub($rows){
		$urls = array_keys($rows);
		$feedModel = new \Wikia\Search\Services\FeedEntitySearchService();
		$feedModel->setQuality( 10 );
		$feedModel->setLang( 'en' );
		$feedModel->setUrls( $urls );
		$rows = $feedModel->query( '' );
		return $rows;
	}

	public function GamesWikiaData(){
		$feedModel = new \Wikia\Search\Services\FeedEntitySearchService();
		$feedModel->setQuality( 1 );
		$feedModel->setLang( 'en' );
		$feedModel->setSorts(['created'=>'desc']);
		$rows = $feedModel->query( '(+host:"dragonage.wikia.com" AND +categories_mv_en:"News")
		| (+host:"warframe.wikia.com" AND +categories_mv_en:"Blog posts")
		| (+host:"monsterhunter.wikia.com" AND +categories_mv_en:"News")
		| (+host:"darksouls.wikia.com" AND +categories_mv_en:"News")
		| (+host:"halo.wikia.com" AND +categories_mv_en:"Blog_posts/News")
		| (+host:"gta.wikia.com" AND +categories_mv_en:"News")
		| (+host:"fallout.wikia.com" AND +categories_mv_en:"News")
		| (+host:"elderscrolls.wikia.com" AND +categories_mv_en:"News")
		| (+host:"leagueoflegends.wikia.com" AND +categories_mv_en:"News_blog")' );
		return $rows;
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