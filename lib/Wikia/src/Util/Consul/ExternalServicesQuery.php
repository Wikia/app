<?php
namespace Wikia\Util\Consul;
use Wikia\Logger\WikiaLogger;

/**
 * Class for querying Wikia Microservices provided by Consul
 * TODO: do actual request functionality
 */
class ExternalServicesQuery {

	/**
	 * @var $consulService ConsulService
	 */
	protected $consulService;

	const URL_SCHEMA = "http://{host}:{port}/{query_path}";

	public function __construct( ConsulService $consulService ) {
		$this->consulService = $consulService;
		return $this;
	}

	public function getUrl( $queryPath ) {
		$target = $this->consulService->resolve();

		$url = strtr( self::URL_SCHEMA, array(
			'{host}' => $target[ 'host' ],
			'{port}' => $target[ 'port' ],
			'{query_path}' => $queryPath ) );
		return $url;
	}
}
