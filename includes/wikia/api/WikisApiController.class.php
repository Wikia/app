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
	const CACHE_VALIDITY = 86400;//1 day
	const MEMC_NAME = 'SharedWikiApiData:';
	const LANGUAGES_LIMIT = 10;
	const DEFAULT_TOP_EDITORS_NUMBER = 10;
	const DEFAULT_WIDTH = 250;
	const DEFAULT_HEIGHT = null;
	const DEFAULT_SNIPPET_LENGTH = null;
	private static $flagsBlacklist = array( 'blocked', 'promoted' );

	private $keys;
	private $service;

	private static $model = null;

	public function __construct() {
		parent::__construct();
		self::$model = new WikisModel();
	}

	/**
	 * Get the top wikis by pageviews optionally filtering by vertical (hub) and/or language
	 *
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The comma-separated list of language codes (e.g. en,de,fr,es,it, etc.) to use as a filter
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
		$langs = $this->request->getArray( self::PARAMETER_LANGUAGES );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );

		if ( !empty( $langs ) &&  count($langs) > self::LANGUAGES_LIMIT) {
			throw new LimitExceededApiException( self::PARAMETER_LANGUAGES, self::LANGUAGES_LIMIT );
		}

		$results = self::$model->getTop( $langs, $hub );
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
	 * @requestParam string $lang [OPTIONAL] The comma-separated list of language codes (e.g. en,de,fr,es,it, etc.) to use as a filter
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
		$langs = $this->request->getArray( self::PARAMETER_LANGUAGES );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$includeDomain = $this->request->getBool( 'includeDomain', false );

		if ( empty( $keyword ) ) {
			throw new MissingParameterApiException( self::PARAMETER_KEYWORD );
		}

		if ( !empty( $langs ) &&  count($langs) > self::LANGUAGES_LIMIT) {
			throw new LimitExceededApiException( self::PARAMETER_LANGUAGES, self::LANGUAGES_LIMIT );
		}

		$results = self::$model->getByString($keyword, $langs, $hub, $includeDomain );

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
		$ids = $this->request->getVal( self::PARAMETER_WIKI_IDS, null );
		if ( !empty( $ids ) ) {
			$ids = explode( ',', $ids );
		} else {
			throw new MissingParameterApiException( self::PARAMETER_WIKI_IDS );
		}
		$imageWidth = $this->request->getVal( 'width', null );
		$imageHeight = $this->request->getVal( 'height', null );
		$length = $this->request->getVal( 'snippet', static::DEFAULT_SNIPPET_LENGTH );

		$items = array();
		foreach ( $ids as $wikiId ) {
//			if ( ( $cached = $this->getFromCacheWiki( $wikiId ) ) !== false ) {
				if( false ) {
				//get from cache
				$wikiInfo = $cached;
			} else {
				//get data providers
				$wikiInfo = array_merge(
					[ 'id' => $wikiId ],
					$this->getFromWikiFactory( $wikiId ),
					$this->getFromService( $wikiId ),
					$this->getFromModel( $wikiId, $imageWidth, $imageHeight )
				);
				$this->cacheWikiData( $wikiInfo );
			}
			//post process thumbnails and snippet
			$wikiInfo = array_merge(
				$wikiInfo,
				$this->getImageData( $wikiInfo[ 'image' ], $imageWidth, $imageHeight )
			);
			//set snippet
			$wikiInfo[ 'desc' ] = $this->getSnippet( $wikiInfo[ 'desc' ], $length );
			//add to result
			$items[ $wikiId ] = $wikiInfo;
		}
		$this->response->setVal( 'items', $items );
		wfProfileOut( __METHOD__ );
	}

	protected function getImageData( $imageName, $width = null, $height = null  ) {
		if ( $width === null && $height === null ) {
			//take img from findfile
			$img = wffindFile( $imageName );
			$width = $img->getWidth();
			$height = $img->getHeight();
			$imgUrl = $img->getFullUrl();
		} else {
			//take form image serving
			$width = ( $width !== null ) ? $width : static::DEFAULT_WIDTH;
			$height = ( $height !== null ) ? $height : static::DEFAULT_HEIGHT;
			$imageServing = new ImageServing(null, $width, $height);
			$imgUrl = $imageServing->getUrl( $imageName, $width, $height );
		}

		return [
			'image' => $imgUrl,
			'dimensions' => [
				'width' => $width,
				'height' => $height
			]
		];
	}

	protected function getFromModel( $id ) {
		$results = self::$model->getDetails( [ $id ] );
		$flags = [];
		foreach ( $results[ $id ][ 'flags' ] as $name => $val ) {
			if ( $val == true && !in_array( $name, static::$flagsBlacklist ) ) {
				$flags[] = $name;
			}
		}

		return [
			'headline' => $results[ $id ][ 'headline' ],
			'flags' => $flags,
			'desc' => $results[ $id ][ 'desc' ],
			'image' => $results[ $id ][ 'image' ]
		];
	}

	protected function getFromWikiFactory( $id ) {
		$wikiObj = WikiFactory::getWikiByID( $id );
		return [
			'title' => $wikiObj->city_title,
			'url' => $wikiObj->city_url
		];
	}

	protected function getFromService( $id ) {
		$service = $this->getWikiService();
		$wikiStats = $service->getSiteStats( $id );
		$topUsers = $service->getTopEditors( $id, static::DEFAULT_TOP_EDITORS_NUMBER, true );
		return [
			'stats' => [
				'edits' => (int) $wikiStats[ 'edits' ],
				'articles' => (int) $wikiStats[ 'articles' ],
				'pages' => (int) $wikiStats[ 'pages' ],
				'users' => (int) $wikiStats[ 'users' ],
				'activeUsers' => (int) $wikiStats[ 'activeUsers' ],
				'images' => (int) $wikiStats[ 'images' ],
				'videos' => (int) $service->getTotalVideos( $id ),
				'admins' => count( $service->getWikiAdminIds( $id ) )
			],
			'topUsers' => array_keys( $topUsers )
		];
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

	protected function getMemCacheKey( $wikiId ) {
		if ( !isset( $this->keys[ $wikiId ] ) ) {
			$this->keys[ $wikiId ] =  wfsharedMemcKey( static::MEMC_NAME.$wikiId );
		}
		return $this->keys[ $wikiId ];
	}

	protected function cacheWikiData( $wikiInfo ) {
		global $wgMemc;
		$key = $this->getMemCacheKey( $wikiInfo[ 'id' ] );
		$wgMemc->set( $key, $wikiInfo, static::CACHE_VALIDITY );
	}

	protected function getFromCacheWiki( $wikiId ) {
		global $wgMemc;
		$key = $this->getMemCacheKey( $wikiId );
		return $wgMemc->get( $key );
	}
}