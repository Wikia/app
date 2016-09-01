<?php

class WikiaMaps extends WikiaObject {

	const REAL_MAP_THUMB_EXPIRE_TIME = 86400; // 1 day
	const ENTRY_POINT_MAP = 'map';
	const ENTRY_POINT_MAP_DATA = 'map_data';
	const ENTRY_POINT_RENDER = 'render';
	const ENTRY_POINT_TILE_SET = 'tile_set';
	const ENTRY_POINT_POI_CATEGORY = 'poi_category';
	const ENTRY_POINT_POI = 'poi';

	const STATUS_DONE = 0;
	const STATUS_PROCESSING = 1;
	const STATUS_FAILED = 3;

	const MAP_HEIGHT = 300;
	const MAP_WIDTH = 1600;

	const HTTP_SUCCESS_OK = 200;
	const HTTP_CREATED_CODE = 201;
	const HTTP_ACCEPTED_CODE = 202;
	const HTTP_UPDATED = 303;

	const MAP_THUMB_PREFIX = '/thumb/';
	const DELTA_Y_DEFAULT = 1;
	const DELTA_Y_CENTERED = 5;
	const THUMB_ALIGNMENT_CENTER = 'center';

	const DB_DUPLICATE_ENTRY ='ER_DUP_ENTRY';

	const MAP_NOT_DELETED = 0;
	const MAP_DELETED = 1;

	/**
	 * @var array API connection config
	 */
	private $config = [];

	/**
	 * @var array Sorting options array message key => sorting column pairs
	 */
	private $sortingOptions = [
		'wikia-interactive-maps-sort-newest-to-oldest' => 'created_on_desc',
		'wikia-interactive-maps-sort-alphabetical' => 'title_asc',
		'wikia-interactive-maps-sort-recently-updated' => 'updated_on_desc',
	];

	public function __construct( $config ) {
		parent::__construct();
		$this->config = $config;
	}

	/**
	 * Create Wikia Maps request URL
	 *
	 * @param array $segments
	 * @param array $params
	 *
	 * @return string - URL
	 */
	public function buildUrl( Array $segments, Array $params = [] ) {
		return sprintf(
			'%s://%s:%d/api/%s/%s%s',
			$this->config[ 'protocol' ],
			$this->config[ 'hostname' ],
			$this->config[ 'port' ],
			$this->config[ 'version' ],
			implode( '/',  $segments ),
			!empty( $params ) ? '?' . http_build_query( $params ) : ''
		);
	}

	/**
	 * Wrapper for Http::get() with authorization token attached
	 *
	 * @param String $url
	 *
	 * @return Array
	 */
	public function sendGetRequest( $url ) {
		return $this->processServiceResponse(
			Http::get( $url, 'default', $this->getHttpRequestOptions() )
		);
	}

	/**
	 * Wrapper for Http::post() with authorization token attached
	 *
	 * @param String $url
	 * @param Array $data
	 *
	 * @return Array
	 */
	private function postRequest( $url, $data ) {
		return $this->processServiceResponse(
			Http::post( $url, $this->getHttpRequestOptions( $data ) )
		);
	}

	/**
	 * Wrapper for Http::request() with authorization token attached
	 *
	 * @param String $url
	 * @param Array $data
	 *
	 * @return Array
	 */
	private function putRequest( $url, $data ) {
		return $this->processServiceResponse(
			Http::request( 'PUT', $url, $this->getHttpRequestOptions( $data ) )
		);
	}

	/**
	 * Wrapper for Http::request() with authorization token attached
	 *
	 * @param String $url
	 *
	 * @return Array
	 */
	private function deleteRequest( $url ) {
		return $this->processServiceResponse(
			Http::request( 'DELETE', $url, $this->getHttpRequestOptions() )
		);
	}

	/**
	 * Get Map instances from IntMaps API server
	 *
	 * @param Array $params an array with parameters which will be added to the url after ? sign
	 *
	 * @return mixed
	 */
	public function getMapsFromApi( Array $params ) {
		$mapsData = new stdClass();
		$url = $this->buildUrl( [ self::ENTRY_POINT_MAP ], $params );
		$response = $this->sendGetRequest( $url );

		if( $response[ 'success' ] ) {
			$mapsData = $response[ 'content' ];

			// Add map size to maps and human status messages
			array_walk( $mapsData->items, function( &$map ) {
				if( $map->status === static::STATUS_FAILED ) {
					unset( $map );
				} else {
					$map->map_width = static::MAP_WIDTH;
					$map->map_height = static::MAP_HEIGHT;
					$map->done = (int)$map->status === static::STATUS_DONE;
				}
			} );
		}

		if( isset( $mapsData->total ) ) {
			return $mapsData;
		}

		return false;
	}

	/**
	 * Sends requests to Wikia Maps service to get data about a map and tiles it's connected with
	 *
	 * @param integer $mapId Map id
	 * @param array $params additional parameters
	 *
	 * @return mixed
	 *
	 * @todo: change the service API in the way that we don't have to send two requests
	 */
	public function getMapByIdFromApi( $mapId,  $params = []) {
		$url = $this->buildUrl( [ self::ENTRY_POINT_MAP, $mapId ], $params );
		$response = $this->sendGetRequest( $url );

		$map = $response[ 'content' ];
		if( !empty( $map->tile_set_url ) ) {
			$response = $this->sendGetRequest( $map->tile_set_url );

			$tilesData = $response[ 'content' ];

			if( !is_null( $tilesData ) ) {
				$map->image = $tilesData->image;
			}
		}

		return $map;
	}

	/**
	 * Sends requests to Wikia Maps service to get data about a map with a list of POIs and POI categories
	 *
	 * @param integer $mapId Map id
	 * @param array $params additional parameters
	 *
	 * @return mixed
	 */
	public function getMapDataByIdFromApi( $mapId,  $params = []) {
		$url = $this->buildUrl( [ self::ENTRY_POINT_MAP_DATA, $mapId ], $params );
		$response = $this->sendGetRequest( $url );

		$mapData = $response[ 'content' ];
		return $mapData;
	}

	/**
	 * Returns render empty point for map (adds the language for each request)
	 *
	 * @param array $segments URL segments
	 * @param array $params Additional get params
	 * @return string URL
	 */
	public function getMapRenderUrl( Array $segments, Array $params = [] ) {
		array_unshift( $segments, self::ENTRY_POINT_RENDER );
		return $this->buildUrl( $segments, $params );
	}

	/**
	 * Returns a list of params for the
	 *
	 * @param Integer $mapCityId
	 *
	 * @return array
	 */
	public function getMapRenderParams( $mapCityId ) {
		$params = [];
		$params[ 'uselang' ] = $this->wg->Lang->getCode();

		if ( $this->shouldHideAttribution( $mapCityId ) ) {
			$params[ 'hideAttr' ] = '1';
		}

		return $params;
	}

	/**
	 * Decides where to hide attribution bar on a map
	 * For now only for usages inside community that created the map
	 *
	 * @param Integer $mapCityId
	 *
	 * @return bool
	 */
	public function shouldHideAttribution( $mapCityId ) {
		return intval( $mapCityId ) === intval( $this->wg->CityId );
	}

	/**
	 * Returns an array of sorting options instances
	 *
	 * @param String $selectedSort
	 *
	 * @return array
	 */
	public function getSortingOptions( $selectedSort = null ) {
		$options = [];

		foreach( $this->sortingOptions as $msgKey => $value ) {
			$options[] = $this->buildSortingOption( $msgKey, $value, $selectedSort );
		}

		return $options;
	}

	/**
	 * Sends request to Wikia Maps service and returns list of tile sets
	 *
	 * @param Array $params - request params
	 *
	 * @return Array - list of tile sets
	 */
	public function getTileSets( Array $params ) {
		$url = $this->buildUrl( [ self::ENTRY_POINT_TILE_SET ], $params );

		//TODO: consider caching the response
		$response = $this->sendGetRequest( $url );

		return $response;
	}

	/**
	 * Sends request to Wikia Maps service and returns tile set data
	 *
	 * @param Integer $tileSetId
	 * @return mixed
	 */
	public function getTileSet( $tileSetId ) {
		$url = $this->buildUrl( [ self::ENTRY_POINT_TILE_SET, $tileSetId ] );

		$response = $this->processServiceResponse(
			Http::get( $url, 'default', $this->getHttpRequestOptions() )
		);

		return $response;
	}

	/**
	 * Sends a request to delete a map instance
	 *
	 * @param integer $mapId
	 * @param integer $deleted Is map being deleted or undeleted
	 *
	 * @return bool
	 */
	public function updateMapDeletionStatus( $mapId, $deleted ) {
		$payload = [
			'deleted' => $deleted
		];
		$url = $this->buildUrl( [ self::ENTRY_POINT_MAP, $mapId ] );
		return $this->putRequest( $url, $payload );
	}

	/**
	 * Sends a request to IntMap Service API to create a map with given parameters
	 *
	 * @param Array $mapData array with required parameters to service API
	 *
	 * @return Array
	 */
	public function saveMap( $mapData ) {
		return $this->postRequest(
			$this->buildUrl( [ self::ENTRY_POINT_MAP ] ),
			$mapData
		);
	}

	/**
	 * Sends a request to IntMap Service API to create a tiles' set with given parameters
	 *
	 * @param Array $tileSetData array with required parameters to service API
	 *
	 * @return Array
	 */
	public function saveTileset( $tileSetData ) {
		return $this->postRequest(
			$this->buildUrl( [ self::ENTRY_POINT_TILE_SET ] ),
			$tileSetData
		);
	}

	/**
	 * Sends a request to IntMap Service API to get all parent POI categories
	 */
	public function getParentPoiCategories() {
		$params = [
			'parentsOnly' => 1 // it has to be like that: http://jonathonhill.net/2011-09-30/http_build_query-surprise/
		];

		$url = $this->buildUrl( [ self::ENTRY_POINT_POI_CATEGORY ], $params );

		//TODO: consider caching the response
		$response = $this->sendGetRequest( $url );

		if ( $response[ 'success' ] ) {
			foreach ( $response[ 'content' ] as &$parentPoiCategory ) {
				if ( isset( $parentPoiCategory->name ) ) {
					// MOB-2272 - translate default POI categories names
					$msgKey = 'wikia-interactive-maps-poi-categories-default-' . mb_strtolower( $parentPoiCategory->name );
					$parentPoiCategory->name = wfMessage( $msgKey )->plain();
				}

				$parentPoiCategory = array_intersect_key( (array) $parentPoiCategory, array_flip( [ 'id', 'name' ] ) );
			}
		}

		return $response;
	}

	/**
	 * Sends a request to IntMap Service API to create a POI category with given parameters
	 *
	 * @param Array $poiCategoryData array with required parameters to service API
	 *
	 * @return Array
	 */
	public function savePoiCategory( $poiCategoryData ) {
		return $this->postRequest(
			$this->buildUrl( [ self::ENTRY_POINT_POI_CATEGORY ] ),
			$poiCategoryData
		);
	}

	/**
	 * Sends a request to IntMap Service API to update a POI category with given parameters
	 *
	 * @param Integer $poiCategoryId
	 * @param Array $poiCategoryData array with required parameters to service API
	 *
	 * @return Array
	 */
	public function updatePoiCategory( $poiCategoryId, $poiCategoryData ) {
		return $this->putRequest(
			$this->buildUrl( [ self::ENTRY_POINT_POI_CATEGORY, $poiCategoryId ] ),
			$poiCategoryData
		);
	}

	/**
	 * Sends a request to IntMap Service API to delete a POI category
	 *
	 * @param Integer $poiCategoryId
	 *
	 * @return Array
	 */
	public function deletePoiCategory( $poiCategoryId ) {
		return $this->deleteRequest(
			$this->buildUrl( [ self::ENTRY_POINT_POI_CATEGORY, $poiCategoryId ] )
		);
	}

	/**
	 * Sends a request to IntMap Service API to create a point of interest (POI) with given parameters
	 *
	 * @param Array $poiData array with required parameters to service API
	 *
	 * @return Array
	 */
	public function savePoi( $poiData ) {
		return $this->postRequest(
			$this->buildUrl( [ self::ENTRY_POINT_POI ] ),
			$poiData
		);
	}

	/**
	 * Sends a request to IntMap Service API to update a point of interest (POI) with given parameters
	 *
	 * @param Integer $poiId unique id of existing POI
	 * @param Array $poiData array with required parameters to service API
	 *
	 * @return Array
	 */
	public function updatePoi( $poiId, $poiData ) {
		return $this->putRequest(
			$this->buildUrl( [ self::ENTRY_POINT_POI, $poiId ] ),
			$poiData
		);
	}

	/**
	 * Sends a request to IntMap Service API to delete a point of interest (POI)
	 *
	 * @param Integer $poiId unique id of existing POI
	 *
	 * @return Array
	 */
	public function deletePoi( $poiId ) {
		return $this->deleteRequest(
			$this->buildUrl( [ self::ENTRY_POINT_POI, $poiId ] )
		);
	}

	/**
	 * Creates a stdClass representing sorting option
	 *
	 * @param String $msgKey message key for MW wfMessage() function
	 * @param String $value value of the option
	 * @param String $selected value of already selected option; null by default
	 *
	 * @return stdClass
	 */
	private function buildSortingOption( $msgKey, $value, $selected = null ) {
		$option = new stdClass();
		$option->name = wfMessage( $msgKey )->plain();
		$option->value = $value;

		if( !is_null( $selected ) && $selected === $value ) {
			$option->selected = true;
		}

		return $option;
	}

	/**
	 * Returns default parent_poi_category_id from config
	 *
	 * @throws WikiaMapsConfigException
	 * @return integer
	 */
	public function getDefaultParentPoiCategory() {
		if ( !isset( $this->config[ 'default-parent-poi-category-id' ] ) ) {
			throw new WikiaMapsConfigException( 'Default parent POI category wasn\'t found in config' );
		}

		return $this->config[ 'default-parent-poi-category-id' ];
	}

	/**
	 * Returns results array with success and content elements
	 *
	 * @param MWHttpRequest $response
	 * @todo: how about extracting results to an object?
	 */
	private function processServiceResponse( MWHttpRequest $response ) {
		$status = $response->getStatus();
		$content = json_decode( $response->getContent() );

		$success = $this->isSuccess( $status, $content );
		if( !$success && is_null( $content ) ) {
			$results[ 'success' ] = false;
			$content = new stdClass();
			$content->message = wfMessage( 'wikia-interactive-maps-service-error' )->parse();
		} else if( !$success && !is_null( $content ) ) {
			$results[ 'success' ] = false;
		} else {
			$results[ 'success' ] = true;
		}

		$results[ 'content' ] = $content;
		return $results;
	}

	/**
	 * Returns true if HTTP request was successfully processed
	 *
	 * @param Integer $status HTTP response status
	 * @param String $content HTTP response content
	 *
	 * @return bool
	 */
	private function isSuccess( $status, $content ) {
		$isStatusOK = in_array( $status, [
			self::HTTP_SUCCESS_OK,
			self::HTTP_CREATED_CODE,
			self::HTTP_ACCEPTED_CODE,
			self::HTTP_UPDATED
		] );

		// MW Http::request() can return 200 HTTP code if service is offline
		// that's why we check content here
		if( $isStatusOK || ( $status === self::HTTP_SUCCESS_OK && !is_null( $content ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns default options for Http::request() method
	 *
	 * @param array $postData
	 *
	 * @return array
	 */
	public function getHttpRequestOptions( Array $postData = [] ) {
		$options = [
			'returnInstance' => true,
			//'noProxy' => true,
		];

		if( !empty( $this->config[ 'token' ] ) ) {
			$options[ 'headers' ][ 'Authorization' ] = $this->config[ 'token' ];
		}

		if ( !empty( $postData ) ) {
			$options[ 'postData' ] = json_encode( $postData );
		}

		if ( isset( $this->config[ 'httpProxy' ] ) && false === $this->config[ 'httpProxy' ] ) {
			$options[ 'noProxy' ] = true;
		}

		return $options;
	}

	/**
	 * @desc returns URL to the cropped thumb of an image
	 *
	 * @param String $url - image url
	 * @param Integer $width desired width of a thumbnail
	 * @param Integer $height desired height of a thumbnail
	 * @param String $align - crop align (origin || center)
	 *
	 * @return String - thumbnail URL
	 */
	public function createCroppedThumb( $url, $width, $height, $align = self::THUMB_ALIGNMENT_CENTER ) {
		$breakPoint = strrpos( $url, '/' );
		$baseURL = substr( $url, 0, $breakPoint );
		$fileName = substr( $url , $breakPoint + 1 );
		$deltaY = $align === self::THUMB_ALIGNMENT_CENTER ? self::DELTA_Y_CENTERED : self::DELTA_Y_DEFAULT;

		return ImagesService::getThumbUrlFromFileUrl(
			$baseURL . self::MAP_THUMB_PREFIX . $fileName,
			$width . 'x' . $height . 'x' . $deltaY
		);
	}

	/**
	 * Returns an URL for an image from article with given title
	 *
	 * @param String $titleText
	 * @param Integer $width
	 * @param Integer $height
	 *
	 * @return string
	 */
	public function getArticleImage( $titleText, $width, $height ) {
		$title = Title::newFromText( $titleText );

		if( !is_null( $title ) ) {
			$articleId = $title->getArticleId();
			$is = new ImageServing( [ $articleId ], $width, $height );
			$images = $is->getImages( 1 );

			if( !empty( $images[ $articleId ] ) ) {
				$image = array_pop( $images[ $articleId ] );
				return $image[ 'url' ];
			}
		}

		return '';
	}
}
