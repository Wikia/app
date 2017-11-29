<?php

namespace Wikia\Service\Gateway;


use Http;
use Wikia\Logger\WikiaLogger;

class ConsulUrlProvider implements UrlProvider {
	const BASE_URL = "consul_url_provider_base_url";
	const SERVICE_TAG = "consul_url_provider_tag";

	const HEALTH_URL = '{consulUrl}/v1/health/service/{serviceName}?passing&tag={serviceTag}';

	/** @var string */
	private $consulUrl;

	/** @var string */
	private $dc;

	/** @var string */
	private $serviceTag;

	/** @var string[][string] */
	private $cache;

	/**
	 * @Inject({
	 *  Wikia\Service\Gateway\ConsulUrlProvider::BASE_URL,
	 *  Wikia\Service\Gateway\ConsulUrlProvider::SERVICE_TAG})
	 * @param string $consulUrl
	 * @param string $serviceTag
	 * @param string $dc DataCenter
	 */
	function __construct( $consulUrl, $serviceTag, $dc = '' ) {
		if ( empty( $consulUrl ) || empty( $serviceTag ) ) {
			throw new \InvalidArgumentException ( "consulUrl or serviceTag not set" );
		}

		$this->consulUrl = $consulUrl;
		$this->dc = $dc;
		$this->serviceTag = $serviceTag;
		$this->cache = [];
	}

	public function getUrl( $serviceName ) {
		if (!isset($this->cache[$serviceName])) {
			$this->cache[$serviceName] = [];
			$healthUrl = $this->getHealthUrl($serviceName);
			$response = Http::Request( "GET", $healthUrl, [ 'noProxy' => true ] );
			$jsonResponse = json_decode($response, true);

			if ( !empty( $jsonResponse ) && is_array( $jsonResponse ) ) {
				foreach ($jsonResponse as $node) {
					$address = $node['Node']['Address'];
					$port = $node['Service']['Port'];
					$this->cache[$serviceName][] = "${address}:${port}";
				}
			}
		}

		if (empty($this->cache[$serviceName])) {
			WikiaLogger::instance()->warning(__METHOD__ . " Empty URL returned from ConsulUrlProvider", ["service_name" => $serviceName, "service_tag" => $this->serviceTag]);
			return "";
		}

		$index = mt_rand(0, count($this->cache[$serviceName]) - 1);

		WikiaLogger::instance()->info( "Url provider", [ 'provider_url' => $this->cache[$serviceName][$index] ] );
		return $this->cache[$serviceName][$index];
	}

	private function getHealthUrl($serviceName) {
		$url = strtr( self::HEALTH_URL, [
			'{consulUrl}' => $this->consulUrl,
			'{serviceName}' => $serviceName,
			'{serviceTag}' => $this->serviceTag,
		] );

		if ( !empty( $this->dc ) ) {
			$url .= "&dc={$this->dc}";
		}

		return $url;
	}
}
