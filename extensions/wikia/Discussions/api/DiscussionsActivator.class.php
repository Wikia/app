<?php

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\SitesApi;
use Swagger\Client\Discussion\Models\SiteInput;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class DiscussionsActivator {

	const SERVICE_NAME = 'discussion';
	const TIMEOUT = 5;
	const SITE_NAME_MAX_LENGTH = 256;

	private $cityId;
	private $cityName;
	private $cityLang;

	private $sitesApi;
	private $logger;

	public function __construct( int $cityId, string $cityName, string $cityLang ) {
		$this->cityId = $cityId;
		$this->cityName = $cityName;
		$this->cityLang = $cityLang;

		$this->sitesApi = $this->getSitesApi();
		$this->logger = Wikia\Logger\WikiaLogger::instance();
	}

	public function activateDiscussions() {
		if ( $this->isDiscussionsActive() ) {
			return;
		}

		$siteInput = $this->getSiteInput();
		try {
			$this->sitesApi->createSite( $siteInput, F::app()->wg->TheSchwartzSecretToken );
		} catch ( ApiException $e ) {
			$this->logAndThrowError( $e );
		}
	}

	private function getSiteInput() : SiteInput {
		return new SiteInput(
			[
				'id' => $this->cityId,
				'name' => substr( $this->cityName, 0, self::SITE_NAME_MAX_LENGTH ),
				'language_code' => $this->cityLang
			]
		);
	}

	public function isDiscussionsActive() {
		try {
			$this->sitesApi->getSite( $this->cityId );
			return true;
		} catch ( ApiException $e ) {
			$this->logger->info( 'DISCUSSIONS Getting site caused an error',
				[
					'siteId' => $this->cityId,
					'error' => $e->getMessage(),
				] );
			return false;
		}
	}

	private function getSitesApi() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		/** @var SitesApi $api */
		$api = $apiProvider->getApi( self::SERVICE_NAME, SitesApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		return $api;
	}

	private function logAndThrowError( Exception $e ) {
		$this->logger->critical(
			'DISCUSSIONS Creating site caused an error',
			[
				'siteId' => $this->cityId,
				'error' => $e->getMessage()
			]
		);
		throw new ErrorPageError( 'unknown-error', 'discussions-activate-error' );
	}
}
