<?php
/**
 * Controller to fetch informations about wikis
 *
 * Available only on the www.wikia.com main domain.
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikisApiController extends WikiaApiController {
	const ITEMS_PER_BATCH = 25;
	const PARAMETER_KEYWORD = 'string';
	const PARAMETER_WIKI_IDS = 'ids';
	const CACHE_VALIDITY = 86400;//1 day
	const MEMC_NAME = 'SharedWikiApiData:';
	const DEFAULT_TOP_EDITORS_NUMBER = 10;
	const DEFAULT_WIDTH = 250;
	const DEFAULT_HEIGHT = null;
	const DEFAULT_SNIPPET_LENGTH = null;

	private $keys;

	private static $model = null;

	public function __construct() {
		parent::__construct();
		self::$model = new WikisModel();
	}

	/**
	 * Get the top wikis by pageviews optionally filtering by vertical (hub) and/or language
	 *
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 *
	 * @responseParam array $items The list of top wikis by pageviews matching the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 *
	 * @example http://www.wikia.com/wikia.php?controller=WikisApi&method=getList&hub=Gaming&lang=en
	 */
	public function getList() {
		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->getVal( 'lang', null ) );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$results = self::$model->getTop( $lang, $hub );
		$batches = wfPaginateArray( $results, $limit, $batch );

		foreach ( $batches as $name => $value ) {
			$this->response->setVal( $name, $value );
		}

		$this->response->setCacheValidity(
			604800 /* 1 week */,
			604800 /* 1 week */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
	}

	/**
	 * Finds wikis which name or topic match a keyword optionally filtering by vertical (hub) and/or language,
	 * the total amount of results is limited to 250 items
	 *
	 * @requestParam string $keyword search term
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The number of items per each batch/page, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 * @requestParam bool $includeDomain [OPTIONAL] Wheter to include wikis' domains as search targets or not,
	 * defaults to false
	 *
	 * @responseParam array $items The list of wikis matching the keyword and the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 *
	 * @example http://www.wikia.com/wikia.php?controller=WikisApi&method=getByString&string=call+of+duty&hub=Gaming&lang=en
	 */
	public function getByString() {
		wfProfileIn( __METHOD__ );

		$keyword = trim( $this->request->getVal( self::PARAMETER_KEYWORD, null ) );
		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->getVal( 'lang', null ) );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$includeDomain = $this->request->getBool( 'includeDomain', false );

		if ( empty( $keyword ) ) {
			throw new MissingParameterApiException( self::PARAMETER_KEYWORD );
		}

		$results = self::$model->getByString($keyword, $lang, $hub, $includeDomain );

		if( is_array( $results ) ) {
			$batches = wfPaginateArray( $results, $limit, $batch );

			foreach ( $batches as $name => $value ) {
				$this->response->setVal( $name, $value );
			}
		} else {
			throw new NotFoundApiException();
		}

		//store only for 24h to allow new wikis
		//to appear in a reasonable amount of time in the search
		//results
		$this->response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get details about one or more wikis.
	 *
	 * @requestParam string $ids A string with a comma-separated list of wiki ID's
	 *
	 * @responseParam array A list of results with the wiki ID as the index, each item has a headline, desc, image and flags property
	 *
	 * @example http://www.wikia.com/wikia.php?controller=WikisApi&method=getDetails&ids=3125,490
	 */
	public function getDetails() {
		wfProfileIn( __METHOD__ );

		$ids = $this->request->getVal( self::PARAMETER_WIKI_IDS, null );

		if ( !empty( $ids ) ) {
			$ids = explode( ',', $ids );
		} else {
			throw new MissingParameterApiException( self::PARAMETER_WIKI_IDS );
		}

		$results = self::$model->getDetails( $ids );

		foreach ( $results as &$res ) {
			//image data transformation
			$imageUrl = null;
			$img = wffindFile( $res['image'] );

			if ( !empty( $img ) ) {
				$imageUrl = $img->getFullUrl();
			}

			$res['image'] = $imageUrl;

			//flags data transformation
			$flags = array();
			//those flags are used internally,
			//they shouldn't be exposed via the API
			$blacklist = array( 'blocked', 'promoted' );

			foreach ( $res['flags'] as $name => $val ) {
				if ( $val == true && !in_array( $name, $blacklist ) ) {
					$flags[] = $name;
				}
			}

			$res['flags'] = $flags;

			//remove redundant data available via other methods
			unset( $res['hubId'] );
			unset( $res['lang'] );
			unset( $res['url'] );
			unset( $res['name'] );
		}

		$this->setVal( 'items', $results );

		//store only for 24h to allow new wikis
		//to appear in a reasonable amount of time in the search
		//results
		$this->response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Gets the information about wikis
	 *
	 * @requestParam array $ids The list of wiki ids that will be fetched
	 * @requestParam int $height [OPTIONAL] Thumbnail height in pixels
	 * @requestParam int $width [OPTIONAL] Thumbnail width in pixels
	 * @requestParam int $snippet [OPTIONAL] Maximum number of words returned in description
	 *
	 * @responseParam array $items The list of wikis, each containing: title, url, description, thumbnail, no. of articles, no. of photos, list of top contributors, no. of videos
	 *
	 * @example &ids=159,831,3125
	 * @example &ids=159,831,3125&width=100
	 * @example &ids=159,831,3125&height=100&width=100&snippet=25
	 */
	public function getWikiData() {
		wfProfileIn( __METHOD__ );
		$ids = $this->request->getArray( 'ids' );
		$imageWidth = $this->request->getInt( 'width', static::DEFAULT_WIDTH );
		$imageHeight = $this->request->getInt( 'height', static::DEFAULT_HEIGHT );
		$length = $this->request->getVal( 'snippet', static::DEFAULT_SNIPPET_LENGTH );

		$items = array();
		$service = new WikiService();
		foreach ( $ids as $wikiId ) {
			if ( ( $cached = $this->getFromCacheWiki( $wikiId ) ) !== false ) {
				//get from cache
				$wikiInfo = $cached;
			} else {
				//get data providers
				$wikiObj = WikiFactory::getWikiByID( $wikiId );
				$wikiStats = $service->getSiteStats( $wikiId );
				$topUsers = $service->getTopEditors( $wikiId, static::DEFAULT_TOP_EDITORS_NUMBER, true );

				$wikiInfo = array(
					'wikiId' => (int) $wikiId,
					'articles' => (int) $wikiStats[ 'articles' ],
					'images' => (int) $wikiStats[ 'images' ],
					'videos' => (int) $service->getTotalVideos( $wikiId ),
					'topUsers' => array_keys( $topUsers ),
					'title' => $wikiObj->city_title,
					'url' => $wikiObj->city_url
				);
				//cache data
				$this->cacheWikiData( $wikiInfo );
			}
			$wikiDesc = $service->getWikiDescription( [ $wikiId ], $imageWidth, $imageHeight );
			//set snippet
			$wikiInfo[ 'description' ] = $this->getSnippet( isset( $wikiDesc[ $wikiId ] ) ? $wikiDesc[ $wikiId ]['desc'] : '', $length );
			//add image, its cached on different level
			$wikiInfo[ 'thumbnail' ] = isset( $wikiDesc[ $wikiId ] ) ? $wikiDesc[ $wikiId ]['image_url'] : '';
			//add to result
			$items[] = $wikiInfo;
		}

		$this->response->setVal( 'items', $items );
		wfProfileOut( __METHOD__ );
	}

	protected function getSnippet( $text, $length = null ) {
		if ( $length !== null ) {
			return implode( ' ', array_slice( explode( ' ', $text ), 0, $length ) );
		}
		return $text;
	}

	protected function getMemCacheKey( $wikiId ) {
		if ( !isset( $this->keys[ $wikiId ] ) ) {
			$this->keys[ $wikiId ] =  wfsharedMemcKey( static::MEMC_NAME.$wikiId );
		}
		return $this->keys[ $wikiId ];
	}

	protected function cacheWikiData( $wikiInfo ) {
		global $wgMemc;
		$key = $this->getMemCacheKey( $wikiInfo[ 'wikiId' ] );
		$wgMemc->set( $key, $wikiInfo, static::CACHE_VALIDITY );
	}

	protected function getFromCacheWiki( $wikiId ) {
		global $wgMemc;
		$key = $this->getMemCacheKey( $wikiId );
		return $wgMemc->get( $key );
	}
}