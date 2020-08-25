<?php
declare( strict_types = 1 );

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Wikia\Logger\Loggable;
use Wikia\Service\Constants;

/**
 * Client class for the resources of Discussion service.
 * @package Fandom\FeedsReportedPage\Gateway
 */
class DiscussionGateway {
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
	 * @param bool $canViewHidden if user is permitted to see hidden posts
	 * @param bool $canViewHiddenInContainer if user is permitted to see hidden posts in given container
	 * @param string $containerType
	 * @param int $userId
	 * @return array|null an object with reported posts on success, or null if an error occurred
	 */
	public function getReportedPosts( array $pagination, bool $viewableOnly, bool $canViewHidden,
									  bool $canViewHiddenInContainer, ?string $containerType, int $userId ):
	array {
		try {
			$containerTypeParam = empty( $containerType ) ? [] : [
				'containerType' => $containerType
			];

			$response = $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/reported-posts",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => 'mediawiki-app',
						Constants::HELIOS_AUTH_HEADER => $userId
					],
					RequestOptions::QUERY => array_filter( $pagination ) + [
						'viewableOnly' => $viewableOnly ? 'true' : 'false',
						'canViewHiddenPosts' => $canViewHidden ? 'true' : 'false',
						'canViewHiddenPostsInContainer' => $canViewHiddenInContainer ? 'true' : 'false',
					] + $containerTypeParam,
				]
			);

			return $this->entity( $response );
		} catch ( GuzzleException $e ) {
			$this->error( 'error while loading reported posts', [
				'exception' => $e,
			] );

			return [];
		}
	}

	public function getReportDetails( string $postId, int $userId ): array {
		try {
			$response = $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/posts/{$postId}/report/details",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => 'mediawiki-app',
						Constants::HELIOS_AUTH_HEADER => $userId
					],
					RequestOptions::TIMEOUT => 3.0
				]
			);

			return [
				'statusCode' => $response->getStatusCode(),
				'body' => $this->entity( $response ),
			];
		} catch ( Exception $e ) {
			$this->error( 'error while loading report details', [
				'exception' => $e,
			] );

			return [
				'statusCode' => \WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR,
				'body' => []
			];
		}
	}

	/**
	 * Extract the body of the given HTTP response and attempt to deserialize it as JSON.
	 * Return the deserialized value if the body was a valid JSON object or array, return null otherwise.
	 *
	 * @param ResponseInterface $response
	 * @return array|null
	 */
	private function entity( ResponseInterface $response ): array {
		$body = (string)$response->getBody();
		$entity = json_decode( $body, true );

		if ( is_array( $entity ) ) {
			return $entity;
		}

		return [];
	}
}
