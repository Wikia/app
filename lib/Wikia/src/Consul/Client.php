<?php

/**
 * A helper class that uses sensiolabs/consul-php-sdk for getting the list of service nodes
 *
 * @see PLATFORM-1489
 * @see https://www.consul.io/docs/agent/http/health.html#health_service
 */

namespace Wikia\Consul;

use SensioLabs\Consul\ServiceFactory;
use Wikia\Logger\WikiaLogger;
use Wikia\Util\Assert;

class Client {

	use \Wikia\Logger\Loggable;

	protected $logger;

	/* @var \SensioLabs\Consul\Services\Health $api */
	protected $api;

	function __construct() {
		$this->logger = WikiaLogger::instance();

		$consulService = new ServiceFactory( [], $this->logger );
		$this->api = $consulService->get( 'health' );
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
	function getNodes( $service, $tag ) {
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
	 * Helper method for getting IP addresses of all nodes hidden behind consul
	 *
	 * $catalog->getNodesFromHostname( 'slave.db-smw.service.consul' )
	 *
	 * @param string $hostname
	 * @return array list of IP addresses
	 */
	function getNodesFromHostname( $hostname ) {
		Assert::true( self::isConsulAddress( $hostname ), __METHOD__ . ' should get a Consul address', $this->getLoggerContext() );

		list( $tag, $service ) = explode( '.', $hostname );
		return $this->getNodes( $service, $tag );
	}

	/**
	 * Example: Wikia\Consul\Catalog::isConsulAddress( 'slave.db-smw.service.consul' )
	 *
	 * @param $address
	 * @preturn bool true if the given address is a consul one
	 */
	static function isConsulAddress( $address ) {
		return endsWith( $address, '.service.consul' );
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
