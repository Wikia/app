<?php

namespace Wikia\FeedsAndPosts\Discussion;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use WebRequest;
use Wikia\Logger\Loggable;
use Wikia\Service\Constants;

class DiscussionGateway {
	use Loggable;

	const API_TIMEOUT = 3.0;

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

	public function castPollVote( string $pollId, array $answerIds, int $userId ) {
		return $this->makeCall( function () use ( $pollId, $answerIds, $userId ) {
			return $this->httpClient->put(
				"{$this->serviceUrl}/internal/{$this->wikiId}/polls/{$pollId}/votes",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId,
						'Content-Type' => 'application/json',
					],
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
					RequestOptions::BODY => json_encode( $answerIds ),
				] );
		} );
	}

	public function getPollVoters( string $pollId, ?string $answerId ) {
		return $this->makeCall( function () use ( $pollId, $answerId ) {
			return $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/polls/{$pollId}/voters",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
					],
					RequestOptions::QUERY => [
						'answerId' => $answerId,
					],
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function upVotePost( string $postId, int $userId, array $userTraceHeaders ) {
		return $this->makeCall( function () use ( $postId, $userId, $userTraceHeaders ) {
			return $this->httpClient->post(
				"{$this->serviceUrl}/internal/{$this->wikiId}/votes/post/{$postId}",
				[
					RequestOptions::HEADERS => [ WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
												 Constants::HELIOS_AUTH_HEADER => $userId ] +
											   $userTraceHeaders,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function downVotePost( string $postId, int $userId, array $userTraceHeaders ) {
		return $this->makeCall( function () use ( $postId, $userId, $userTraceHeaders ) {
			return $this->httpClient->delete(
				"{$this->serviceUrl}/internal/{$this->wikiId}/votes/post/{$postId}",
				[
					RequestOptions::HEADERS => [ WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
												 Constants::HELIOS_AUTH_HEADER => $userId ] +
											   $userTraceHeaders,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	private function makeCall( callable $callback ): array {
		try {
			$response = $callback();

			return [
				'statusCode' => $response->getStatusCode(),
				'body' => $this->entity( $response ),
			];
		} catch ( BadResponseException $e ) {
			$this->error( 'error while loading data from discussion', [
				'exception' => $e,
			] );

			return [
				'statusCode' => $e->getResponse()->getStatusCode(),
				'body' => $this->entity( $e->getResponse() ),
			];
		} catch ( Exception $e ) {
			$this->error( 'error while loading data from discussion', [
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
	 * Return the deserialized value if the body was a valid JSON object or array, return empty
	 * array otherwise.
	 *
	 * @param ResponseInterface $response
	 * @return array
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