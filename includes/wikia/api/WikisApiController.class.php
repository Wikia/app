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
	const CACHE_1_DAY = 86400;//1 day
	const CACHE_1_WEEK = 604800;//1 day
	const MEMC_NAME = 'SharedWikiApiData:';
	const LANGUAGES_LIMIT = 10;
	const DEFAULT_TOP_EDITORS_NUMBER = 10;
	const DEFAULT_WIDTH = 250;
	const DEFAULT_HEIGHT = null;
	const DEFAULT_SNIPPET_LENGTH = null;
	const CACHE_VERSION = 2;
	const WORDMARK = 'Wiki-wordmark.png';
	private static $flagsBlacklist = array( 'blocked', 'promoted' );

	private $keys;
	private $service;

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
		$batches = wfPaginateArray( $results, $limit, $batch );

		if ( $expand ) {
			$batches = $this->expandBatches( $batches );
		}

		foreach ( $batches as $name => $value ) {
			$this->response->setVal( $name, $value );
		}
		$this->response->setCacheValidity(
			static::CACHE_1_WEEK,
			static::CACHE_1_WEEK,
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

		if( is_array( $results ) ) {
			$batches = wfPaginateArray( $results, $limit, $batch );

			if ( $expand ) {
				$batches = $this->expandBatches( $batches );
			}

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
			static::CACHE_1_DAY,
			static::CACHE_1_DAY,
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


	public function getDetails() {
		wfProfileIn( __METHOD__ );
		$ids = $this->request->getVal( self::PARAMETER_WIKI_IDS, null );
		if ( !empty( $ids ) ) {
			$ids = explode( ',', $ids );
		} else {
			throw new MissingParameterApiException( self::PARAMETER_WIKI_IDS );
		}

		$params = $this->getDetailsParams();
		$items = array();
		foreach ( $ids as $wikiId ) {
			$details = $this->getWikiDetails( $wikiId, $params[ 'imageWidth' ], $params[ 'imageHeight' ], $params[ 'length' ] );
			if ( !empty( $details ) ) {
				$items[ (int) $wikiId ] = $details;
			}
		}
		$this->response->setVal( 'items', $items );

		//set varnish caching
		$this->response->setCacheValidity(
			static::CACHE_1_DAY,
			static::CACHE_1_DAY,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
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
		$ids = $this->request->getArray( 'ids' );
		$imageWidth = $this->request->getInt( 'width', static::DEFAULT_WIDTH );
		$imageHeight = $this->request->getInt( 'height', static::DEFAULT_HEIGHT );
		$length = $this->request->getVal( 'snippet', static::DEFAULT_SNIPPET_LENGTH );

		$items = array();
		$service = new WikiService();
		foreach ( $ids as $wikiId ) {
			if ( ( $cached = $this->getFromCacheWiki( $wikiId, __METHOD__ ) ) !== false ) {
				//get from cache
				$wikiInfo = $cached;
			} else {
				//get data providers
				$wikiObj = WikiFactory::getWikiByID( $wikiId );
				$wikiStats = $service->getSiteStats( $wikiId );
				$topUsers = $service->getTopEditors( $wikiId, static::DEFAULT_TOP_EDITORS_NUMBER, true );

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

	protected function expandBatches( $batches ) {
		if ( isset( $batches[ 'items' ] ) ) {
			$expanded = [];
			$params = $this->getDetailsParams();
			foreach( $batches[ 'items' ] as $item ) {
				$details = $this->getWikiDetails( $item[ 'id' ], $params[ 'imageWidth' ], $params[ 'imageHeight' ], $params[ 'length' ] );
				$expanded[] = array_merge( $item, $details );
			}
			$batches[ 'items' ] = $expanded;
		}
		return $batches;
	}

	protected function getDetailsParams() {
		return [
			'imageWidth' => $this->request->getVal( 'width', null ),
			'imageHeight' => $this->request->getVal( 'height', null ),
			'length' => $this->request->getVal( 'snippet', static::DEFAULT_SNIPPET_LENGTH )
		];
	}

	protected function getWikiDetails( $wikiId, $width = null, $height = null, $snippet = null ) {
		if ( ( $cached = $this->getFromCacheWiki( $wikiId ) ) !== false ) {
			$wikiInfo = $cached;
		} else {
			//get data providers
			$factoryData = $this->getFromWikiFactory( $wikiId, $exists );
			if ( $exists ) {
				$wikiInfo = array_merge(
					[
						'id' => (int) $wikiId,
						'wordmark' => $this->getWikiWordmarkImage( $wikiId )
					],
					$factoryData,
					$this->getFromService( $wikiId ),
					$this->getFromWAMService( $wikiId )
				);
			} else {
				$wikiInfo = [
					'id' => (int) $wikiId,
					'exists' => false
				];
			}
			$this->cacheWikiData( $wikiInfo );
		}
		//return empty result if wiki does not exist
		if ( isset( $wikiInfo[ 'exists' ] ) ) {
			return [];
		}
		//post process thumbnails
		if ( isset( $wikiInfo[ 'image' ] ) ) {
			$wikiInfo = array_merge(
				$wikiInfo,
				$this->getImageData( $wikiInfo[ 'image' ], $width, $height )
			);
		} else {
			$wikiInfo[ 'image' ] = '';
		}
		//set snippet
		if ( isset( $wikiInfo[ 'desc' ] ) ) {
			$length = ( $snippet !== null ) ? $snippet : static::DEFAULT_SNIPPET_LENGTH;
			$wikiInfo[ 'desc' ] = $this->getSnippet( $wikiInfo[ 'desc' ], $length );
		} else {
			$wikiInfo[ 'desc' ] = '';
		}
		return $wikiInfo;
	}

	protected function getImageData( $imageName, $width = null, $height = null  ) {
		$img = wfFindFile( $imageName );
		if ( $img instanceof WikiaLocalFile ) {
			if ( $width == null && $height == null ) {
				//get original image if no cropping
				$imgUrl = $img->getFullUrl();
			} else {
				$width = ( $width !== null ) ? $width : static::DEFAULT_WIDTH;
				$height = ( $height !== null ) ? $height : static::DEFAULT_HEIGHT;
				$imageServing = new ImageServing( null, $width, $height );
				$imgUrl = $imageServing->getUrl( $img, $width, $height );
			}
			return [
				'image' => $imgUrl,
				'original_dimensions' => [
					'width' => $img->getWidth(),
					'height' => $img->getHeight()
				]
			];
		}
		return [];
	}

	protected function getWikiWordmarkImage( $id ) {
		$title = GlobalTitle::newFromText( static::WORDMARK, NS_FILE, $id );
		if ( $title !== null ) {
			$file = new GlobalFile( $title );
			if ( $file !== null && $file->exists() ) {
				return $file->getUrl();
			}
		}
		return '';
	}

	protected function getFromWAMService( $id ) {
		$service = new WAMService();
		return [
			'wam_score' => $service->getCurrentWamScoreForWiki( $id )
		];
	}

	protected function getFromWikiFactory( $id, &$exists = null ) {
		$exists = false;
		$wikiObj = WikiFactory::getWikiByID( $id );
		if ( $wikiObj ) {
			$exists = true;
			return [
				'title' => $wikiObj->city_title,
				'url' => $wikiObj->city_url,
			];
		}
		return [];
	}

	protected function getFromService( $id ) {
		$service = $this->getWikiService();
		$wikiStats = $service->getSiteStats( $id );
		$topUsers = $service->getTopEditors( $id, static::DEFAULT_TOP_EDITORS_NUMBER, true );
		$modelData = $service->getDetails( [ $id ] );

		//filter out flags
		$flags = [];
		if ( isset( $modelData[ $id ] ) ) {
			foreach ( $modelData[ $id ][ 'flags' ] as $name => $val ) {
				if ( $val == true && !in_array( $name, static::$flagsBlacklist ) ) {
					$flags[] = $name;
				}
			}
		}

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
			'topUsers' => array_keys( $topUsers ),
			'headline' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'headline' ] : '',
			'flags' => $flags,
			'desc' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'desc' ] : '',
			'image' => isset( $modelData[ $id ] ) ? $modelData[ $id ][ 'image' ] : '',
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