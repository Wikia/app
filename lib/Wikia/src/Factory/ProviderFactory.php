<?php
namespace Wikia\Factory;

use Wikia\Logger\WikiaLogger;
use Wikia\Service\Gateway\KubernetesUrlProvider;
use Wikia\Service\Gateway\UrlProvider;
use Wikia\Service\Swagger\ApiProvider;
use Wikia\Util\Statistics\BernoulliTrial;

class ProviderFactory {
	const API_PROVIDER_SAMPLE_RATE = 0.1;

	/** @var UrlProvider $urlProvider */
	private $urlProvider;

	/** @var ApiProvider $apiProvider */
	private $apiProvider;

	public function setUrlProvider( UrlProvider $urlProvider ) {
		$this->urlProvider = $urlProvider;
	}

	public function urlProvider(): UrlProvider {
		if ( $this->urlProvider === null ) {
			global $wgRealEnvironment, $wgWikiaDatacenter;
			$this->urlProvider = new KubernetesUrlProvider( $wgRealEnvironment, $wgWikiaDatacenter );
			$this->urlProvider->setLogger( WikiaLogger::instance() );
		}

		return $this->urlProvider;
	}

	public function apiProvider(): ApiProvider {
		if ( $this->apiProvider === null ) {
			$sampler =  new BernoulliTrial( static::API_PROVIDER_SAMPLE_RATE );

			$this->apiProvider = new ApiProvider( $this->urlProvider(), $sampler );
		}

		return $this->apiProvider;
	}
}
