<?php


class WikiaMaps {

	const DEFAULT_MEMCACHE_EXPIRE_TIME = 3600;

	const ENTRY_MAP = 'map';

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
	private function buildUrl($entryPoint, Array $params = [] ) {
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
	public function cachedRequest( $method,  Array $params, $expireTime = self::DEFAULT_MEMCACHE_EXPIRE_TIME ) {
		$memCacheKey = wfMemcKey( __CLASS__, __METHOD__, json_encode( $params ) );
		return WikiaDataAccess::cache( $memCacheKey, $expireTime, function () use ( $method, $params ) {
			return $this->{ $method }( $params );
		});
	}

	/**
	 * Get Map instances from IntMaps API server
	 *
	 * @param Array $params
	 * @return mixed
	 */
	private function getMapsFromApi( Array $params ) {
		// TODO: Remove mock when we have real data
		return [
			[
				'id' =>  1,
				'status' => 'Processing',
				'title' => 'Title 1',
				'image' => 'http://placekitten.com/2000/300',
				'last_updated' => date('c')
			],
			[
				'id' =>  1,
				'title' => 'Title 2',
				'image' => 'http://placekitten.com/2001/300',
				'last_updated' => date('c')
			]
		];

		$url = $this->buildUrl( self::ENTRY_MAP, $params );
		$response = Http::get( $url );
		if ( $response !== false ) {
			return json_decode( $response, FALSE );
		}
		return false;
	}
}
