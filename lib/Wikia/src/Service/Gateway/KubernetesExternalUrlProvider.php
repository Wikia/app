<?php

namespace Wikia\Service\Gateway;

use InvalidArgumentException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class KubernetesExternalUrlProvider implements UrlProvider, LoggerAwareInterface {
	/** @var LoggerInterface $logger */
	private $logger;

	public function getUrl( $serviceName ) {
		global $wgServicesExternalDomain;
		$url = "${wgServicesExternalDomain}${serviceName}";

		if ( $this->logger ) {
			$this->logger->debug( 'Url provider', [ 'provider_url' => $url ] );
		}

		return $url;
	}

	public function setLogger( LoggerInterface $logger ) {
		$this->logger = $logger;
	}
}
