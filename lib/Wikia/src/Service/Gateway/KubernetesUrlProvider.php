<?php

namespace Wikia\Service\Gateway;

use InvalidArgumentException;
use Wikia\Logger\WikiaLogger;

class KubernetesUrlProvider implements UrlProvider {
	const URL_PROVIDER_WIKIA_ENVIRONMENT = 'url_provider_wikia_environment';
	const URL_PROVIDER_DATACENTER = 'url_provider_datacenter';

	const K8S_URL = "%s.%s.k8s.wikia.net/%s";

	private $env;

	private $dc;

	/**
	 * @Inject({
	 *     Wikia\Service\Gateway\KubernetesUrlProvider::URL_PROVIDER_WIKIA_ENVIRONMENT,
	 *     Wikia\Service\Gateway\KubernetesUrlProvider::URL_PROVIDER_DATACENTER})
	 * @param string $wikiaEnvironment
	 * @param string $dataCenter
	 */
	public function __construct( string $wikiaEnvironment, string $dataCenter ) {
		switch ( $wikiaEnvironment ) {
			case WIKIA_ENV_PROD:
			case WIKIA_ENV_PREVIEW:
			case WIKIA_ENV_VERIFY:
			case WIKIA_ENV_STABLE:
			case WIKIA_ENV_SANDBOX:
				$this->env = WIKIA_ENV_PROD;
				$this->dc = $dataCenter;
				break;
			case WIKIA_ENV_STAGING:
				$this->env = WIKIA_ENV_STAGING;
				$this->dc = $dataCenter;
				break;
			case WIKIA_ENV_DEV:
				$this->env = WIKIA_ENV_DEV;
				$this->dc = "$dataCenter-dev";
				break;
			default:
				throw new InvalidArgumentException( "Invalid environment $wikiaEnvironment" );
		}
	}

	public function getUrl( $serviceName ) {
		$url = sprintf( static::K8S_URL, $this->env, $this->dc, $serviceName );
		WikiaLogger::instance()->info( "Url provider", [ 'provider_url' => $url ] );
		return $url;
	}
}
