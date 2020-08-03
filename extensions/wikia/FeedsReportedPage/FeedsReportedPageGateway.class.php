<?php
declare( strict_types = 1 );

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Wikia\Logger\Loggable;

/**
 * Client class for the resources of Discussion service.
 * @package Fandom\FeedsReportedPage\Gateway
 */
class FeedsReportedPageGateway {
	use Loggable;

	/** @var Client $httpClient */
	private $httpClient;
	/** @var string $serviceUrl */
	private $serviceUrl;
	/** @var int $wikiId */
	private $wikiId;

	public function __construct( Client $httpClient, string $serviceUrl, int $wikiId ) {
		$this->httpClient = $httpClient;
		$this->serviceUrl = $serviceUrl;
		$this->wikiId = $wikiId;
	}

	/**
	 * Get the list of reported posts on the current wiki.
	 * @param array $pagination associative array of pagination query params
	 * @param bool $viewableOnly if hidden posts should be not returned
	 * @param string $containerType
	 * @param int $userId
	 * @return array|null an object with reported posts on success, or null if an error occurred
	 */
	public function getReportedPosts( array $pagination, bool $viewableOnly, ?string $containerType, int $userId ):
	?array {
		try {
			$containerTypeParam = empty( $containerType ) ? [] : [
				'containerType' => $containerType
			];

			$response = $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/reported-posts",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => 1
					],
					RequestOptions::QUERY => array_filter( $pagination ) + [
						'viewableOnly' => $viewableOnly,
						'userId' => $userId,
					] + $containerTypeParam,
				]
			);

			return $this->entityOrNull( $response );
		} catch ( GuzzleException $e ) {
			$this->error( 'error while loading reported posts', [
				'exception' => $e,
			] );

			return null;
		}
	}

	/**
	 * Extract the body of the given HTTP response and attempt to deserialize it as JSON.
	 * Return the deserialized value if the body was a valid JSON object or array, return null otherwise.
	 *
	 * @param ResponseInterface $response
	 * @return array|null
	 */
	private function entityOrNull( ResponseInterface $response ): ?array {
		$body = (string)$response->getBody();
		$entity = json_decode( $body, true );

		if ( is_array( $entity ) ) {
			return $entity;
		}

		return null;
	}
}
