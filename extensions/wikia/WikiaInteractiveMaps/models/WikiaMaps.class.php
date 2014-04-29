<?php


class WikiaMaps {

	const DEFAULT_MEMCACHE_EXPIRE_TIME = 3600;
	const ENTRY_POINT_MAP = 'map';
	const ENTRY_POINT_RENDER = 'render';

	const STATUS_DONE = 0;
	const STATUS_PROCESSING = 1;
	const STATUS_FAILED = 3;

	const MAP_HEIGHT = 300;
	const MAP_WIDTH = 1600;

	/**
	 * @var array API Connection config
	 */
	private $config = [];

	public function __construct( $config ) {
		$this->config = $config;
	}

	/**
	 * @desc Create InteractiveMaps request URL
	 *
	 * @param string $entryPoint
	 * @param array $params
	 * @return string - URL
	 */
	private function buildUrl( $entryPoint, Array $params = [] ) {
		return sprintf(
			'%s://%s:%d/api/%s/%s%s',
			$this->config['protocol'],
			$this->config['hostname'],
			$this->config['port'],
			$this->config['version'],
			$entryPoint,
			!empty( $params ) ? '?' . http_build_query( $params ) : ''
		);
	}

	/**
	 * Call method and store the result in cache for $expireTime
	 *
	 * @param $method
	 * @param array $params
	 * @param int $expireTime
	 * @return Mixed|null
	 */
	public function cachedRequest( $method, Array $params, $expireTime = self::DEFAULT_MEMCACHE_EXPIRE_TIME ) {
		$memCacheKey = wfMemcKey( __CLASS__, __METHOD__, json_encode( $params ) );
		return WikiaDataAccess::cache( $memCacheKey, $expireTime, function () use ( $method, $params ) {
			return $this->{ $method }( $params );
		} );
	}

	/**
	 * Get Map instances from IntMaps API server
	 *
	 * @param Array $params an array with parameters which will be added to the url after ? sign
	 * @return mixed
	 */
	private function getMapsFromApi( Array $params ) {
		$maps = [];
		$url = $this->buildUrl( self::ENTRY_POINT_MAP, $params );
		$response = Http::get( $url );

		if ( $response !== false ) {
			$maps = json_decode( $response );

			// Add map size to maps and human status messages
			array_walk( $maps, function( &$map ) {
				if( $map->status === static::STATUS_FAILED ) {
					unset( $map );
				} else {
					$map->map_width = static::MAP_WIDTH;
					$map->map_height = static::MAP_HEIGHT;
					$map->status = $this->getMapStatusText( $map->status );
				}
			} );
		}

		if( !empty( $maps ) ) {
			return $maps;
		}

		return false;
	}

	/**
	 * @desc Sends requests to IntMap service to get data about a map and tiles it's connected with
	 *
	 * @param Array $params the first element is required and it should be map id passed rest of the array elements
	 *                      will get added as URI parameters after ? sign
	 * @return mixed
	 *
	 * @todo: change the service API in the way that we don't have to send two requests
	 */
	private function getMapByIdFromApi( Array $params ) {
		$mapId = array_shift( $params );
		$url = $this->buildUrl( self::ENTRY_POINT_MAP . '/' . $mapId, $params );
		$response = Http::get( $url );

		$map = json_decode( $response );
		$map->id = $mapId;
		if( !empty( $map->tile_set_url ) ) {
			$response = Http::get( $map->tile_set_url );
			$tilesData = json_decode( $response );

			if( !is_null( $tilesData ) ) {
				$map->image = $tilesData->image;
			}
		}

		return $map;
	}

	/**
	 * @desc Returns render empty point for map
	 *
	 * @param Array $params the first element is required and it should be concatenated {mapId}/{zoom}/{lat}/{lon}
	 *                      rest of the array elements will get added as URI parameters after ? sign
	 * @return string
	 */
	public function getMapRenderUrl( Array $params ) {
		$entryPointParams = array_shift( $params );
		return $this->buildUrl( self::ENTRY_POINT_RENDER . '/' . $entryPointParams, $params );
	}

	/**
	 * @desc Returns human message based on the tiles processing status in database
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

}
