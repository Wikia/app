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

class Catalog {

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
	 * Returns IP addresses of given service healthy nodes
	 *
	 * $catalog->getNodes( 'db-a', 'slave' )
	 *
	 * @param string $service
	 * @param string $tag
	 * @return array list of IP addresses
	 */
	function getNodes( $service, $tag ) {
		global $wgWikiaDatacenter;
		$resp = $this->api->service( $service, [ 'tag' => $tag, 'dc' => $wgWikiaDatacenter ] )->json();

		$nodes = array_map(
			function( $item ) {
				return $item[ 'Address' ];
			},
			$resp
		);

		wfDebug( __METHOD__ . sprintf( ": got nodes for '%s' service ('%s' tag): %s\n", $service, $tag, join(', ', $nodes) ) );
		return $nodes;
	}

	/**
	 * Helper method for getting database nodes hidden behind consul
	 *
	 * $catalog->getDatabaseNodes( 'slave.db-smw.service.consul' )
	 *
	 * @param $db
	 * @return array list of IP addresses
	 */
	function getDatabaseNodes( $db ) {
		list( $tag, $service ) = explode( '.', $db );
		return $this->getNodes( $service, $tag );
	}

	/**
	 * Example: Wikia\Consul\Catalog::isConsulAddress( 'slave.db-smw.service.consul' )
	 *
	 * @param $address
	 * @preturn bool true if the given address is a consul one
	 */
	static function isConsulAddress( $address ) {
		return endsWith( $address, 'service.consul' );
	}
}
