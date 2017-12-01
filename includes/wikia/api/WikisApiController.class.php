<?php

/**
 * Controller to fetch informations about wikis
 *
 * Available only on the www.wikia.com main domain.
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @author Artur Klajnerok <arturk@wikia-inc.com>
 */

class WikisApiController extends WikiaApiController {
	const ITEMS_PER_BATCH = 25;
	const PARAMETER_KEYWORD = 'string';
	const PARAMETER_LANGUAGES = 'lang';
	const PARAMETER_WIKI_IDS = 'ids';
	/** 1 day cache time */
	const CACHE_1_DAY = 86400;
	/** 1 week cache time */
	const CACHE_1_WEEK = 604800;
	const MEMC_NAME = 'SharedWikiApiData:';
	const LANGUAGES_LIMIT = 10;
	const DEFAULT_TOP_EDITORS_NUMBER = 10;
	const DEFAULT_WIDTH = 250;
	const DEFAULT_HEIGHT = null;
	const DEFAULT_SNIPPET_LENGTH = null;
	const CACHE_VERSION = 3;
	const WORDMARK = 'Wiki-wordmark.png';
	const MAX_WIKIS = 250;

	private $keys;
	private $service;
	private $wikiDetails;

	/**
	 * @var CrossOriginResourceSharingHeaderHelper
	 */
	protected $cors;

	public function __construct(){
		parent::__construct();
		$this->cors = new CrossOriginResourceSharingHeaderHelper();
		$this->cors->allowWhitelistedOrigins();
	}

	/**
	 * Get the top wikis by pageviews optionally filtering by vertical (hub) and/or language
	 *
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The comma-separated list of language codes (e.g. en,de,fr,es,it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 * @requestParam string $expand [OPTIONAL] if set will expand result with getDetails data
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
		$langs = $this->request->getArray( self::PARAMETER_LANGUAGES );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$expand = $this->request->getBool( 'expand', false );

		if ( !empty( $langs ) &&  count($langs) > self::LANGUAGES_LIMIT) {
			throw new LimitExceededApiException( self::PARAMETER_LANGUAGES, self::LANGUAGES_LIMIT );
		}

		$results = $this->getWikiService()->getTop( $langs, $hub );
		$results = $this->filterNonCommercial( $results );
		$batches = wfPaginateArray( $results, $limit, $batch );

		if ( $expand ) {
			$batches = $this->expandBatches( $batches );
		}
		$this->setResponseData(
			$batches,
			[ 'urlFields' => [ 'wordmark', 'image' ] ],
			static::CACHE_1_WEEK
		);
	}

	/**
	 * Finds wikis which name or topic match a keyword optionally filtering by vertical (hub) and/or language,
	 * the total amount of results is limited to 250 items
	 *
	 * @requestParam string $keyword search term
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The comma-separated list of language codes (e.g. en,de,fr,es,it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The number of items per each batch/page, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 * @requestParam bool $includeDomain [OPTIONAL] Wheter to include wikis' domains as search targets or not,
	 * defaults to false
	 * @requestParam string $expand [OPTIONAL] if set will expand result with getDetails data
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
		$langs = $this->request->getArray( self::PARAMETER_LANGUAGES );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$includeDomain = $this->request->getBool( 'includeDomain', false );
		$expand = $this->request->getBool( 'expand', false );

		if ( empty( $keyword ) ) {
			throw new MissingParameterApiException( self::PARAMETER_KEYWORD );
		}

		if ( !empty( $langs ) &&  count($langs) > self::LANGUAGES_LIMIT) {
			throw new LimitExceededApiException( self::PARAMETER_LANGUAGES, self::LANGUAGES_LIMIT );
		}

		$results = $this->getWikiService()->getByString( $keyword, $langs, $hub, $includeDomain );
		$results = $this->filterNonCommercial( $results );

		if( is_array( $results ) ) {
			$batches = wfPaginateArray( $results, $limit, $batch );

			if ( $expand ) {
				$batches = $this->expandBatches( $batches );
			}

		} else {
			throw new NotFoundApiException();
		}

		//store only for 24h to allow new wikis
		//to appear in a reasonable amount of time in the search
		//results
		$this->setResponseData(
			$batches,
			[ 'urlFields' => [ 'image', 'wordmark', 'url' ] ],
			static::CACHE_1_DAY
		);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Gets the information about wikis
	 *
	 * @requestParam array $ids The list of wiki ids that will be fetched - returns at most 250 results
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


	public function getDetails() {
		wfProfileIn( __METHOD__ );
		$this->cors->setHeaders($this->response);

		$this->setOutputFieldType( "items", self::OUTPUT_FIELD_TYPE_OBJECT );
		$ids = $this->request->getVal( self::PARAMETER_WIKI_IDS, null );
		if ( empty( $ids ) ) {
			throw new MissingParameterApiException( self::PARAMETER_WIKI_IDS );
		}

		$idList = $this->getArrayParameter( $ids, static::MAX_WIKIS );

		$params = $this->getDetailsParams();
		$items = array();
		foreach ( $idList as $wikiId ) {
			$details = $this->getWikiDetailsService()
				->getWikiDetails( $wikiId, $params[ 'imageWidth' ], $params[ 'imageHeight' ], $params[ 'length' ] );
			if ( !empty( $details ) ) {
				$items[ (int) $wikiId ] = $details;
			}
		}

		$this->setResponseData(
			[ 'items' => $items ],
			[ 'urlFields' => [ 'wordmark', 'image' ] ],
			static::CACHE_1_DAY
		);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Gets the information about wikis [DEPRECATED]
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
		$ids = $this->request->getVal( static::PARAMETER_WIKI_IDS );
		$imageWidth = $this->request->getInt( 'width', static::DEFAULT_WIDTH );
		$imageHeight = $this->request->getInt( 'height', static::DEFAULT_HEIGHT );
		$length = $this->request->getVal( 'snippet', static::DEFAULT_SNIPPET_LENGTH );

		if ( empty( $ids ) ) {
			throw new MissingParameterApiException( static::PARAMETER_WIKI_IDS );
		}

		$idList = $this->getArrayParameter( $ids, static::MAX_WIKIS );

		$items = array();
		$service = $this->getWikiService();
		foreach ( $idList as $wikiId ) {
			if ( ( $cached = $this->getFromCacheWiki( $wikiId, __METHOD__ ) ) !== false ) {
				//get from cache
				$wikiInfo = $cached;
			} else {
				//get data providers
				$wikiObj = WikiFactory::getWikiByID( $wikiId );
				$wikiStats = $service->getSiteStats( $wikiId );
				$topUsers = $service->getTopEditors( $wikiId, static::DEFAULT_TOP_EDITORS_NUMBER );

				$wikiInfo = array(
					'id' => (int) $wikiId,
					'articles' => (int) $wikiStats[ 'articles' ],
					'images' => (int) $wikiStats[ 'images' ],
					'videos' => (int) $service->getTotalVideos( $wikiId ),
					'topUsers' => array_keys( $topUsers ),
					'title' => $wikiObj->city_title,
					'url' => $wikiObj->city_url
				);
				//cache data
				$this->cacheWikiData( $wikiInfo, __METHOD__ );
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

	/**
	 * Get the value of an array request parameter passed as CSV without performing
	 * a potentially expensive explode+count of all items.
	 *
	 * @param string $paramValue
	 * @param int $maxCount
	 * @return array
	 */
	protected function getArrayParameter( $paramValue, $maxCount ) {
		$paramValue = strtok( $paramValue, ',' );
		$values = [];
		$count = 0;

		while ( $paramValue !== false && $count < $maxCount ) {
			$values[] = $paramValue;
			$paramValue = strtok( ',' );

			$count++;
		}

		return $values;
	}

	protected function getNonCommercialWikis() {
		$licensed = new LicensedWikisService();
		return $licensed->getCommercialUseNotAllowedWikis();
	}

	/**
	 * @param Array $wikis
	 * @return array
	 */
	protected function filterNonCommercial( Array $wikis ) {
		$result =[];
		$blackList = $this->getNonCommercialWikis();
		foreach( $wikis as $wiki ) {
			if ( !isset( $blackList[ $wiki['id'] ] ) ) {
				$result[] = $wiki;
			}
		}
		return array_slice($result, 0, self::MAX_WIKIS);
	}

	protected function expandBatches( $batches ) {
		if ( isset( $batches[ 'items' ] ) ) {
			$expanded = [];
			$params = $this->getDetailsParams();
			foreach( $batches[ 'items' ] as $item ) {
				$details = $this->getWikiDetailsService()
					->getWikiDetails( $item[ 'id' ], $params[ 'imageWidth' ], $params[ 'imageHeight' ], $params[ 'length' ] );
				$expanded[] = array_merge( $item, $details );
			}
			$batches[ 'items' ] = $expanded;
		}
		return $batches;
	}

	protected function getDetailsParams() {
		return [
			'imageWidth'  => $this->request->getVal( 'width', null ),
			'imageHeight' => $this->request->getVal( 'height', null ),
			'length'      => $this->request->getVal( 'snippet', static::DEFAULT_SNIPPET_LENGTH ),
		];
	}

	protected function getWikiDetailsService() {
		if ( !isset( $this->wikiDetails ) ) {
			$this->wikiDetails = new WikiDetailsService();
		}
		return $this->wikiDetails;
	}

	protected function getWikiService() {
		if ( !isset( $this->service ) ) {
			$this->service = new WikiService();
		}
		return $this->service;
	}

	protected function getSnippet( $text, $length = null ) {
		if ( $length !== null ) {
			return implode( ' ', array_slice( explode( ' ', $text ), 0, $length ) );
		}
		return $text;
	}

	protected function getMemCacheKey( $seed ) {
		if ( !isset( $this->keys[ $seed ] ) ) {
			$this->keys[ $seed ] =  wfsharedMemcKey( static::MEMC_NAME.static::CACHE_VERSION.':'.$seed );
		}
		return $this->keys[ $seed ];
	}

	protected function cacheWikiData( $wikiInfo, $method = null ) {
		global $wgMemc;
		$seed = $method !== null ? $wikiInfo[ 'id' ].':'.$method : $wikiInfo[ 'id' ];
		$key = $this->getMemCacheKey( $seed );
		$wgMemc->set( $key, $wikiInfo, static::CACHE_1_DAY );
	}

	protected function getFromCacheWiki( $wikiId, $method = null ) {
		global $wgMemc;
		$seed = $method !== null ? $wikiId.':'.$method : $wikiId;
		$key = $this->getMemCacheKey( $seed );
		return $wgMemc->get( $key );
	}
}
