<?php

namespace Wikia\Service\Gateway;

use InvalidArgumentException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class KubernetesUrlProvider implements UrlProvider, LoggerAwareInterface {
	/** @var string $env */
	private $env;

	/** @var string $dc */
	private $dc;

	/** @var LoggerInterface $logger */
	private $logger;

	/**
	 * @param string $environment
	 * @param string $dataCenter
	 */
	public function __construct( string $environment, string $dataCenter ) {
		if ( !in_array( $environment, [ WIKIA_ENV_PROD, WIKIA_ENV_DEV, WIKIA_ENV_STAGING ] ) ) {
			throw new InvalidArgumentException( "Invalid environment $environment" );
		}

		switch ( $environment ) {
			case WIKIA_ENV_DEV:
				$this->env = WIKIA_ENV_DEV;
				$this->dc = "$dataCenter-dev";
				break;
			default:
				$this->env = $environment;
				$this->dc = $dataCenter;
				break;
		}
	}

	public function getUrl( $serviceName ) {
		$url = "{$this->env}.{$this->dc}.k8s.wikia.net/$serviceName";

		$this->logger->debug( "Url provider", [ 'provider_url' => $url ] );

		return $url;
	}

	public function setLogger( LoggerInterface $logger ) {
		$this->logger = $logger;
	}
}
