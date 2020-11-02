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

	public function getThreadByPostId( string $postId, int $userId, array $queryParams ) {
		return $this->makeCall( function () use ( $postId, $userId, $queryParams ) {
			return $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/permalinks/posts/{$postId}",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function getForums( int $userId, array $queryParams ) {
		return $this->makeCall( function () use ( $userId, $queryParams ) {
			return $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/forums",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function getForum( string $forumId, int $userId, array $queryParams ) {
		return $this->makeCall( function () use ( $forumId, $userId, $queryParams ) {
			return $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/forums/{$forumId}",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function createForum( int $userId, array $queryParams, string $payload ) {
		return $this->makeCall( function () use ( $payload, $userId, $queryParams ) {
			return $this->httpClient->post(
				"{$this->serviceUrl}/internal/{$this->wikiId}/forums",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId,
						'Content-Type' => 'application/json',
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::BODY => $payload,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function moveThreadsIntoForum(
		string $forumId, int $userId, array $queryParams, string $payload
	) {
		return $this->makeCall( function () use ( $payload, $userId, $queryParams, $forumId ) {
			return $this->httpClient->post(
				"{$this->serviceUrl}/internal/{$this->wikiId}/forums/{$forumId}/movethreads",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId,
						'Content-Type' => 'application/json',
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::BODY => $payload,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function deleteForum( string $forumId, int $userId, array $queryParams, string $payload ) {
		return $this->makeCall( function () use ( $payload, $userId, $queryParams, $forumId ) {
			return $this->httpClient->delete(
				"{$this->serviceUrl}/internal/{$this->wikiId}/forums/{$forumId}",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId,
						'Content-Type' => 'application/json',
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::BODY => $payload,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function updateForum( string $forumId, int $userId, array $queryParams, string $payload ) {
		return $this->makeCall( function () use ( $payload, $userId, $queryParams, $forumId ) {
			return $this->httpClient->post(
				"{$this->serviceUrl}/internal/{$this->wikiId}/forums/{$forumId}",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId,
						'Content-Type' => 'application/json',
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::BODY => $payload,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function updateForumDisplayOrder( int $userId, array $queryParams, string $payload ) {
		return $this->makeCall( function () use ( $payload, $userId, $queryParams ) {
			return $this->httpClient->post(
				"{$this->serviceUrl}/internal/{$this->wikiId}/forums/displayorder",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId,
						'Content-Type' => 'application/json',
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::BODY => $payload,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function lockThread( int $userId, string $threadId, string $canViewHidden, array $userTraceHeaders ) {
		return $this->makeCall( function () use ( $userId, $threadId, $canViewHidden, $userTraceHeaders ) {
			return $this->httpClient->put(
				"{$this->serviceUrl}/internal/{$this->wikiId}/threads/{$threadId}/lock",
				[
					RequestOptions::HEADERS => [
					   	WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
					   	Constants::HELIOS_AUTH_HEADER => $userId,
				   	] + $userTraceHeaders,
					RequestOptions::QUERY => [
						'canViewHidden' => $canViewHidden,
					],
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function unlockThread( int $userId, string $threadId, string $canViewHidden, array $userTraceHeaders ) {
		return $this->makeCall( function () use ( $userId, $threadId, $canViewHidden, $userTraceHeaders ) {
			return $this->httpClient->delete(
				"{$this->serviceUrl}/internal/{$this->wikiId}/threads/{$threadId}/lock",
				[
					RequestOptions::HEADERS => [
					   	WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
					   	Constants::HELIOS_AUTH_HEADER => $userId,
				   	] + $userTraceHeaders,
					RequestOptions::QUERY => [
						'canViewHidden' => $canViewHidden,
					],
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function updateThread( int $userId, $threadId, string $payload, array $queryParams, array $traceHeaders ) {
		return $this->makeCall( function () use ( $userId, $threadId, $payload, $queryParams, $traceHeaders ) {
			return $this->httpClient->post(
				"{$this->serviceUrl}/internal/{$this->wikiId}/threads/{$threadId}",
				[
					RequestOptions::HEADERS => [
					   	WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
					   	Constants::HELIOS_AUTH_HEADER => $userId,
					   	'Content-Type' => 'application/json'
				    ] + $traceHeaders,
					RequestOptions::QUERY => $queryParams,
					RequestOptions::BODY => $payload,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function deleteThread( int $userId, $threadId, array $queryParams, array $traceHeaders ) {
		return $this->makeCall( function () use ( $userId, $threadId, $queryParams, $traceHeaders ) {
			return $this->httpClient->put(
				"{$this->serviceUrl}/internal/{$this->wikiId}/threads/{$threadId}/delete",
				[
					RequestOptions::HEADERS => [
					   	WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
					   	Constants::HELIOS_AUTH_HEADER => $userId,
					   	'Content-Type' => 'application/json'
				    ] + $traceHeaders,
					RequestOptions::QUERY => $queryParams,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function undeleteThread( int $userId, $threadId, array $queryParams, array $traceHeaders ) {
		return $this->makeCall( function () use ( $userId, $threadId, $queryParams, $traceHeaders ) {
			return $this->httpClient->put(
				"{$this->serviceUrl}/internal/{$this->wikiId}/threads/{$threadId}/undelete",
				[
					RequestOptions::HEADERS => [
					   	WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
					   	Constants::HELIOS_AUTH_HEADER => $userId,
					   	'Content-Type' => 'application/json'
				   	] + $traceHeaders,
					RequestOptions::QUERY => $queryParams,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function createThread( int $userId, $forumId, string $payload, array $queryParams, array $traceHeaders ) {
		return $this->makeCall( function () use ( $userId, $forumId, $payload, $queryParams, $traceHeaders ) {
			return $this->httpClient->post(
				"{$this->serviceUrl}/internal/{$this->wikiId}/forums/{$forumId}/threads",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId,
						'Content-Type' => 'application/json'
					] + $traceHeaders,
					RequestOptions::QUERY => $queryParams,
					RequestOptions::BODY => $payload,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function getThread( int $userId, string $threadId, array $queryParams ) {
		return $this->makeCall( function () use ( $userId, $threadId, $queryParams ) {
			return $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/threads/{$threadId}",
				[
					RequestOptions::HEADERS => [
					   	WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
					   	Constants::HELIOS_AUTH_HEADER => $userId,
					   	'Content-Type' => 'application/json'
				   	],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	public function getThreads( int $userId, array $queryParams ) {
		return $this->makeCall( function () use ( $userId, $queryParams ) {
			return $this->httpClient->get(
				"{$this->serviceUrl}/internal/{$this->wikiId}/threads",
				[
					RequestOptions::HEADERS => [
						WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1',
						Constants::HELIOS_AUTH_HEADER => $userId,
						'Content-Type' => 'application/json'
					],
					RequestOptions::QUERY => $queryParams,
					RequestOptions::TIMEOUT => self::API_TIMEOUT,
				] );
		} );
	}

	private function makeCall( callable $callback ): array {
		try {
			$response = $callback();

			return [
				'statusCode' => $response->getStatusCode() == 204 ? 200 : $response->getStatusCode(),
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
