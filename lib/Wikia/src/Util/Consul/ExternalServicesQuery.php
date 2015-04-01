<?php
namespace Wikia\Util\Consul;
use Wikia\Logger\WikiaLogger;

/**
 * Class for querying Wikia Microservices provided by Consul
 * Using Wikia's Http class and ConsulService
 */
class ExternalServicesQuery {

	/**
	 * @var $consulService ConsulService
	 */
	protected $consulService;
	protected $httpOptions = [ ];

	const URL_SCHEMA = "http://{host}:{port}/{query_path}";
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';

	public function __construct( ConsulService $consulService ) {
		$this->consulService = $consulService;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getHttpOptions() {
		return $this->httpOptions;
	}

	/**
	 * Options for Http class
	 * @param array $httpOptions
	 * @return $this
	 */
	public function setHttpOptions( $httpOptions ) {
		$this->httpOptions = $httpOptions;
		return $this;
	}

	protected function getUrl( $queryPath ) {
		$target = $this->consulService->resolve();

		$url = strtr( self::URL_SCHEMA, array(
			'{host}' => $target[ 'host' ],
			'{port}' => $target[ 'port' ],
			'{query_path}' => $queryPath ) );
		return $url;
	}

	protected function request( $method, $queryPath, $additionalOptions = [ ] ) {
		$url = $this->getUrl( $queryPath );
		$result = $this->real_request( $method, $url, array_merge( $this->getHttpOptions(), (array)$additionalOptions ) );

		if ( !$result ) {
			$logger = WikiaLogger::instance();
			$logger->error( "ExternalServiceQuery fail", [
				"serviceName" => $this->consulService->getConfig()->getServiceName(),
				"serviceTag" => $this->consulService->getConfig()->getServiceTag(),
				"url" => $url ] );
		}
		return $result;
	}

	protected function real_request( $method, $url, $options ) {
		return \Http::request( $method, $url, $options );
	}

	/**
	 * @param $queryPath
	 * @return string|bool
	 */
	public function get( $queryPath ) {
		return $this->request( self::METHOD_GET, $queryPath );
	}

	/**
	 * @param $queryPath
	 * @param $postData (key=>value array)
	 * @return string|bool
	 */
	public function post( $queryPath, $postData ) {
		return $this->request( self::METHOD_POST, $queryPath, [ "postData" => $postData ] );
	}
}
