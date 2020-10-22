<?php

/**
 * A helper class that uses sensiolabs/consul-php-sdk for getting the list of service nodes
 *
 * @see PLATFORM-1489
 * @see SUS-3249 - added support for Consul queries
 * @see https://www.consul.io/docs/agent/http/health.html#health_service
 * @see https://www.consul.io/api/query.html
 */

namespace Wikia\Consul;

use SensioLabs\Consul\Client as ConsulClient;
use SensioLabs\Consul\ServiceFactory;
use Wikia\Logger\Loggable;
use Wikia\Logger\WikiaLogger;
use Wikia\Util\Assert;

class Client {

	use Loggable;

	protected $logger;
	protected $options;

	/* @var \SensioLabs\Consul\Services\Health $api */
	protected $api;

	/* @var \SensioLabs\Consul\Services\Catalog $api */
	protected $catalog;

	function __construct(array $options = []) {
		$this->logger = WikiaLogger::instance();
		$this->options = $options;

		$consulService = new ServiceFactory( $options, $this->logger );
		$this->api = $consulService->get( 'health' );
		$this->catalog = $consulService->get( 'catalog' );
	}

	/**
	 * Returns IP addresses (with ports) of given service healthy nodes
	 *
	 * $catalog->getNodes( 'db-a', 'slave' )
	 * $catalog->getNodes( 'chat-private', 'prod' )
	 *
	 * $ curl "http://127.0.0.1:8500/v1/health/service/db-g?tag=slave&passing"
	 *
	 * @param string $service
	 * @param string $tag
	 * @return array list of IP addresses with ports ie. 127.0.0.1:1234
	 */
	function getNodes( string $service, string $tag ) : array {
		$resp = $this->api->service( $service, [ 'tag' => $tag, 'passing' => true ] )->json();

		$nodes = array_map(
			function( $item ) {
				return $item[ 'Node' ][ 'Address' ] . ':' . $item[ 'Service' ][ 'Port' ];
			},
			$resp
		);

		wfDebug( __METHOD__ . sprintf( ": got nodes for '%s' service ('%s' tag): %s\n", $service, $tag, join(', ', $nodes) ) );
		return $nodes;
	}

	/**
	 * Returns IP addresses (with ports) of given service healthy nodes
	 *
	 * $catalog->getNodesFromConsulQuery( 'geo-db-dev-db-slave' )
	 *
	 * $ curl 'http://127.0.0.1:8500/v1/query/geo-db-a-slave/execute?pretty=&passing='
	 *
	 * @param string $query
	 * @return array list of IP addresses with ports ie. 127.0.0.1:1234
	 */
	private function getNodesFromConsulQuery( string $query ) : array {
		$consulClient = new ConsulClient( $this->options );
		$resp = $consulClient->get(
			sprintf( '/v1/query/%s/execute?passing=', $query )
		)->json();

		$nodes = array_map(
			function( $item ) {
				return $item[ 'Node' ][ 'Address' ] . ':' . $item[ 'Service' ][ 'Port' ];
			},
			$resp['Nodes']
		);

		wfDebug( __METHOD__ .sprintf( ": got nodes for '%s' query: %s\n", $query, join(', ', $nodes) ) );
		return $nodes;
	}

	/**
	 * Helper method for getting IP addresses of all nodes hidden behind consul
	 *
	 * $consul->getNodesFromHostname( 'slave.db-smw.service.consul' )
	 * $consul->getNodesFromHostname( 'geo-db-g-slave.query.consul.' )
	 *
	 * @param string $hostname
	 * @return array list of IP addresses
	 * @throws \Exception
	 */
	function getNodesFromHostname( string $hostname ) {
		Assert::true( self::isConsulAddress( $hostname ), __METHOD__ . ' should get a Consul address', $this->getLoggerContext() );

		if ( self::isConsulQuery($hostname) ) {
			// e.g. geo-db-g-slave.query.consul.
			$query = self::parseConsulQuery( $hostname );
			return $this->getNodesFromConsulQuery( $query );
		}
		elseif ( self::isConsulServiceAddress( $hostname ) ) {
			// e.g. slave.db-g.service.consul
			list( $tag, $service ) = self::parseConsulServiceAddress( $hostname);
			return $this->getNodes( $service, $tag );
		}
		else {
			throw new \Exception( __METHOD__ . " - {$hostname} is neither consul query nor consul service address" );
		}
	}

	/**
	 * @param string $env either prod or dev
	 * @return string[]
	 */
	function getDataCentersForEnv( string $env ) : array {
		global $wgConsulDataCenters;
		return $wgConsulDataCenters[$env];
	}

	/**
	 * Return Consul base URL for a current environment
	 *
	 * @return string
	 */
	static function getConsulBaseUrl() : string {
		return sprintf( 'http://consul.service.consul.:8500' );
	}

	/**
	 * Return Consul base URL for a specific data-center
	 *
	 * @param string $dc
	 * @return string
	 */
	static function getConsulBaseUrlForDC( string $dc ) : string {
		return sprintf( 'http://consul.service.%s.consul.:8500', $dc );
	}

	/**
	 * Example: Wikia\Consul\Client::isConsulAddress( 'slave.db-smw.service.consul' )
	 * Example: Wikia\Consul\Client::isConsulAddress( 'slave.db-smw.service.consul.' )
	 *
	 * @param string $address
	 * @return bool true if the given address is a consul one
	 */
	static function isConsulAddress( string $address ) : bool {
		return endsWith( $address, '.consul' ) || endsWith( $address, '.consul.' );
	}

	/**
	 * Example: Wikia\Consul\Client::isConsulServiceAddress( 'slave.db-smw.service.consul' )
	 * Example: Wikia\Consul\Client::isConsulServiceAddress( 'slave.db-smw.service.consul.' )
	 *
	 * @param string $address
	 * @return bool true if the given address is a consul service one
	 */
	static function isConsulServiceAddress( string $address ) : bool {
		return endsWith( $address, '.service.consul' ) || endsWith( $address, '.service.consul.' );
	}

	/**
	 * Returns a service and tag part from consul address.
	 *
	 * Example: 'slave.db-smw.service.consul' => ['slave', 'db-smw']
	 *
	 * @param string $address
	 * @return string[]|false
	 */
	static function parseConsulServiceAddress( string $address ) {
		if ( self::isConsulServiceAddress( $address ) ) {
			list( $tag, $service ) = explode( '.', $address, 3 );
			return [ $tag, $service ];
		}
		else {
			return false;
		}
	}

	/**
	 * Example: Wikia\Consul\Client::isConsulQuery( 'geo-db-g-slave.query.consul' )
	 * Example: Wikia\Consul\Client::isConsulQuery( 'geo-db-h-slave.query.consul.' )
	 *
	 * @see https://www.consul.io/api/query.html
	 *
	 * @param string $address
	 * @return bool true if the given address is a consul query
	 */
	static function isConsulQuery( string $address ) : bool {
		return endsWith( $address, '.query.consul' ) || endsWith( $address, '.query.consul.' );
	}

	/**
	 * Returns a query from consul address.
	 *
	 * It basically returns the first part of the dot-separated domain
	 *
	 * Example: 'geo-db-g-slave.query.consul' => 'geo-db-g-slave'
	 *
	 * @param string $address
	 * @return string|false
	 */
	static function parseConsulQuery( string $address ) {
		return self::isConsulQuery( $address )
			? strtok( $address, '.' )
			: false;
	}

	/**
	 * Make it easier to "grep" through the logs
	 *
	 * @return array
	 */
	protected function getLoggerContext() {
		return [
			'class' => __CLASS__
		];
	}
}
