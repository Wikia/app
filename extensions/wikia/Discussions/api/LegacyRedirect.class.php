<?php

use Swagger\Client\Discussion\Api\LegacyRedirectsApi;
use Wikia\Factory\ServiceFactory;

class LegacyRedirect {

	const SERVICE_NAME = 'discussion';
	const TIMEOUT = 5;
	const SITE_NAME_MAX_LENGTH = 256;

	private $siteId;

	private $legacyRedirectApi;
	private $logger;

	public function __construct( int $siteId ) {
		$this->siteId = $siteId;

		$this->legacyRedirectApi = $this->getLegacyRedirectApi();
		$this->logger = Wikia\Logger\WikiaLogger::instance();
	}

	/**
	 * Return a path to redirect the client to based on a board ID
	 *
	 * @param int $boardId
	 * @return string
	 */
	public function getBoardRedirect( $boardId ) {
		try {
			$response = $this->legacyRedirectApi->getForumRedirect( $this->siteId, $boardId );
			return $response->getPath();
		} catch ( \Exception $e ) {
			$this->logError( $e );
		}

		return '';
	}

	/**
	 * Return a path to redirect the client to based on a thread ID
	 *
	 * @param int $threadId
	 * @return string
	 */
	public function getThreadRedirect( $threadId ) {
		try {
			$response = $this->legacyRedirectApi->getThreadRedirect( $this->siteId, $threadId );
			return $response->getPath();
		} catch ( \Exception $e ) {
			$this->logError( $e );
		}

		return '';
	}

	private function getLegacyRedirectApi() {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();

		/** @var LegacyRedirectsApi $api */
		$api = $apiProvider->getApi( self::SERVICE_NAME, LegacyRedirectsApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );
		$api->getApiClient()
			->getConfig()
			->addDefaultHeader( WebRequest::WIKIA_INTERNAL_REQUEST_HEADER, 1 );

		return $api;
	}

	private function logError( Exception $e ) {
		$this->logger->error(
			'DISCUSSIONS Retrieving legacy Forum redirect caused an error',
			[
				'siteId' => $this->siteId,
				'error' => $e->getMessage()
			]
		);
	}
}
