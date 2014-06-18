<?php

class WikiaMaps {

	const DEFAULT_MEMCACHE_EXPIRE_TIME = 3600;
	const ENTRY_POINT_MAP = 'map';
	const ENTRY_POINT_RENDER = 'render';
	const ENTRY_POINT_TILE_SET = 'tile_set';
	const ENTRY_POINT_PIN_TYPE = 'poi_category';
	const ENTRY_POINT_POI = 'poi';

	const STATUS_DONE = 0;
	const STATUS_PROCESSING = 1;
	const STATUS_FAILED = 3;

	const MAP_HEIGHT = 300;
	const MAP_WIDTH = 1600;

	const MAP_TYPE_CUSTOM = 'custom';
	const MAP_TYPE_GEO = 'geo';

	const HTTP_CREATED_CODE = 201;
	const HTTP_SUCCESS_OK = 200;
	const HTTP_UPDATED = 303;
	const HTTP_NO_CONTENT = 204;

	/**
	 * @var array API connection config
	 */
	private $config = [];

	/**
	 * @var array Sorting options array message key => sorting column pairs
	 */
	private $sortingOptions = [
		'wikia-interactive-maps-sort-newest-to-oldest' => 'created_on_desc',
		'wikia-interactive-maps-sort-alphabetical' => 'name_asc',
		'wikia-interactive-maps-sort-recently-updated' => 'updated_on_desc',
	];

	public function __construct( $config ) {
		$this->config = $config;
	}

	/**
	 * Create InteractiveMaps request URL
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
	 * Call method and store the result in cache for $expireTime
	 *
	 * @param $method
	 * @param array $params
	 * @param int $expireTime
	 *
	 * @return Mixed|null
	 */
	public function cachedRequest( $method, Array $params, $expireTime = self::DEFAULT_MEMCACHE_EXPIRE_TIME ) {
		$memCacheKey = wfMemcKey( __CLASS__, __METHOD__, json_encode( $params ) );
		return WikiaDataAccess::cache( $memCacheKey, $expireTime, function () use ( $method, $params ) {
			return $this->{ $method }( $params );
		} );
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
	private function getMapsFromApi( Array $params ) {
		$mapsData = new stdClass();
		$url = $this->buildUrl( [ self::ENTRY_POINT_MAP ], $params );
		$response = $this->processServiceResponse(
			Http::get( $url, 'default', $this->getHttpRequestOptions() )
		);

		if( $response[ 'success' ] ) {
			$mapsData = $response[ 'content' ];

			// Add map size to maps and human status messages
			array_walk( $mapsData->items, function( &$map ) {
				if( $map->status === static::STATUS_FAILED ) {
					unset( $map );
				} else {
					$map->map_width = static::MAP_WIDTH;
					$map->map_height = static::MAP_HEIGHT;
					$map->status_message = $this->getMapStatusText( $map->status );
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
	 * Sends requests to IntMap service to get data about a map and tiles it's connected with
	 *
	 * @param Array $params the first element is required and it should be map id passed rest of the array elements
	 *                      will get added as URI parameters after ? sign
	 * @return mixed
	 *
	 * @todo: change the service API in the way that we don't have to send two requests
	 */
	private function getMapByIdFromApi( Array $params ) {
		$mapId = array_shift( $params );
		$url = $this->buildUrl( [ self::ENTRY_POINT_MAP, $mapId ], $params );
		$response = $this->processServiceResponse(
			Http::get( $url, 'default', $this->getHttpRequestOptions() )
		);

		$map = $response[ 'content' ];
		if( !empty( $map->tile_set_url ) ) {
			$response = $this->processServiceResponse(
				Http::get( $map->tile_set_url, 'default', $this->getHttpRequestOptions() )
			);

			$tilesData = $response[ 'content' ];

			if( !is_null( $tilesData ) ) {
				$map->image = $tilesData->image;
			}
		}

		return $map;
	}

	/**
	 * Returns render empty point for map
	 *
	 * @param Array $params the first element is required and it should be concatenated {mapId}/{zoom}/{lat}/{lon}
	 *                      rest of the array elements will get added as URI parameters after ? sign
	 *
	 * @return string
	 */
	public function getMapRenderUrl( Array $params ) {
		$entryPointParams = array_shift( $params );
		return $this->buildUrl( self::ENTRY_POINT_RENDER . '/' . $entryPointParams, $params );
	}

	/**
	 * Returns human message based on the tiles processing status in database
	 *
	 * @param Integer $status status of tiles processing for the map
	 *
	 * @return String
	 */
	public function getMapStatusText( $status ) {
		$message = '';

		switch( $status ) {
			case static::STATUS_DONE:
				$message = wfMessage( 'wikia-interactive-maps-map-status-done' )->plain();
				break;
			case static::STATUS_PROCESSING:
				$message = wfMessage( 'wikia-interactive-maps-map-status-processing' )->plain();
				break;
		}

		return $message;
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
	 * Sends request to interactive maps service and returns list of tile sets
	 *
	 * @param Array $params - request params
	 *
	 * @return Array - list of tile sets
	 */
	public function getTileSets( Array $params ) {
		$url = $this->buildUrl( [ self::ENTRY_POINT_TILE_SET ], $params );

		//TODO: consider caching the response
		$response = $this->processServiceResponse(
			Http::get( $url, 'default', $this->getHttpRequestOptions() )
		);

		return $response;
	}

	/**
	 * Sends a request to delete a map instance
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function deleteMapById( $mapId ) {
		$payload = [
			'deleted' => true
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

	public function getParentPinTypes() {
		$params = [
			'parents' => 1
		];

		$url = $this->buildUrl( [ self::ENTRY_POINT_PIN_TYPE ], $params );

		//TODO: consider caching the response
		$response = $this->processServiceResponse(
			Http::get( $url, 'default', [
				'returnInstance' => true,
				//TODO this is temporary workaround, remove it before production!
				'noProxy' => true
			] )
		);

		return $response;
	}

	/**
	 * Sends a request to IntMap Service API to create a pin type with given parameters
	 *
	 * @param Array $pinTypeData array with required parameters to service API
	 *
	 * @return Array
	 */
	public function savePinType( $pinTypeData ) {
		return $this->postRequest(
			$this->buildUrl( [ self::ENTRY_POINT_PIN_TYPE ] ),
			$pinTypeData
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
	 * Returns Geo tileset's id from config or 0
	 *
	 * @return integer
	 */
	public function getGeoMapTilesetId() {
		if( isset( $this->config[ 'geo-tileset-id' ] ) ) {
			return $this->config[ 'geo-tileset-id' ];
		}

		return 0;
	}

	/**
	 * Returns default parent_poi_category_id from config or 0
	 *
	 * @return integer
	 */
	public function getDefaultParentPoiCategory() {
		if( isset( $this->config[ 'default-parent-poi-category-id' ] ) ) {
			return $this->config[ 'default-parent-poi-category-id' ];
		}

		return 0;
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
			$results['success'] = false;
			$content = new stdClass();
			$content->message = wfMessage( 'wikia-interactive-maps-service-error' )->parse();
		} else if( !$success && !is_null( $content ) ) {
			$results['success'] = false;
		} else {
			$results['success'] = true;
		}

		$results['content'] = $content;
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
			self::HTTP_CREATED_CODE,
			self::HTTP_UPDATED,
			self::HTTP_NO_CONTENT,
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
	private function getHttpRequestOptions( Array $postData = [] ) {
		$options = [
			'headers' => [
				'Authorization' => $this->config[ 'token' ]
			],
			'returnInstance' => true,
			//TODO: this is temporary workaround, remove it before production!
			'noProxy' => true
		];

		if( !empty( $postData ) ) {
			$options[ 'postData' ] = json_encode( $postData );
		}

		return $options;
	}
}

