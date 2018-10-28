<?php

namespace Wikia\Persistence\User\Attributes;

use Swagger\Client\ApiException;
use Swagger\Client\User\Attributes\Api\UsersAttributesApi;
use Swagger\Client\User\Attributes\Models\AllUserAttributesHalResponse;
use Wikia\CircuitBreaker;
use Wikia\Domain\User\Attribute;
use Wikia\Service\ForbiddenException;
use Wikia\Service\NotFoundException;
use Wikia\Service\PersistenceException;
use Wikia\Service\Swagger\ApiProvider;
use Wikia\Service\UnauthorizedException;

class AttributePersistence {
	const MAX_REQUEST_TIMEOUT_SECONDS = 1;
	const SERVICE_NAME = "user-attribute";

	/** @var ApiProvider */
	private $apiProvider;

	/** @var CircuitBreaker\CircuitBreaker */
	private $circuitBreaker;

	public function __construct( ApiProvider $apiProvider ) {
		$this->apiProvider = $apiProvider;
		$this->circuitBreaker = new CircuitBreaker\RatioBasedCircuitBreaker(self::SERVICE_NAME,
			new CircuitBreaker\ApcuStorage(),
			new CircuitBreaker\Ratio(3, 5),	// failure ratio
			new CircuitBreaker\Ratio(2, 5),	// success ratio
			10.0); // 10s for devbox tests
	}

	/**
	 * @param int $userId
	 * @param string[] $attributes map of attribute names to their values
	 * @return true success, exception otherwise
	 * @throws ForbiddenException
	 * @throws NotFoundException
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function saveAttributes( $userId, array $attributes ) {
		try {
			$this->getApi( $userId )->saveAttributes( $userId, $attributes );
			return true;
		} catch ( ApiException $e ) {
			$this->handleApiException($e);
		}
	}

	/**
	 * Get the user's attributes.
	 *
	 * @param int $userId
	 * @return Attribute[]
	 * @throws ForbiddenException
	 * @throws NotFoundException
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 * @throws \Exception
	 */
	public function getAttributes( $userId ) {

		$attributes = [];
		try {
			foreach ( $this->getAttributesFromApi( $userId )  as $attribute ) {
				$attributes[] = new Attribute( $attribute->getName(), $attribute->getValue() );
			}
		} catch ( ApiException $e ) {
			$this->handleApiException( $e );
		}

		return $attributes;
	}

	/**
	 * @param int $userId
	 * @return \Swagger\Client\User\Attributes\Models\UserAttributeHalResponse[]
	 * @throws ApiException
	 * @throws PersistenceException
	 * @throws \Exception
	 */
	private function getAttributesFromApi( $userId ) {
		//$halResponse = $this->getApi( $userId )->getAllAttributes( $userId );
		// example of using a circuit breaker for to wrap a single method call
		$halResponse = $this->circuitBreaker->wrapCall(
			function() use ($userId) {
				return  $this->getApi( $userId )->getAllAttributes( $userId );
			},
			function( $exception ) {
				if ($exception instanceof ApiException) {
					if ($exception->getCode() == 502 || $exception->getCode() == 504 || $exception->getCode() == 0) {
						return false;
					}
				}
				return true;
			},
			function() {
				throw new ApiException("Circuit breaken open", 504);
			});

		$this->assertValidResponse( $halResponse );

		return $halResponse->getEmbedded()->getProperties();
	}

	/**
	 * @param AllUserAttributesHalResponse $halResponse
	 * @throws PersistenceException
	 */
	private function assertValidResponse( $halResponse ) {
		if ( empty( $halResponse ) ) {
			throw new PersistenceException( "Invalid response from Attribute Service" );
		}
	}

	/**
	 * @param int $userId
	 * @param Attribute $attribute
	 * @return bool
	 * @throws ForbiddenException
	 * @throws NotFoundException
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function deleteAttribute( $userId, Attribute $attribute ) {
		try {
			$this->getApi( $userId )->deleteAttribute( $userId, $attribute->getName() );
			return true;
		} catch ( ApiException $e ) {
			$this->handleApiException( $e );
		}
	}

	/**
	 * @param int $userId
	 * @return UsersAttributesApi
	 */
	private function getApi( $userId ) {
		/** @var UsersAttributesApi $api $api */
		$api = $this->apiProvider->getAuthenticatedApi( self::SERVICE_NAME, $userId, UsersAttributesApi::class );

		$api->getApiClient()->getConfig()->setCurlTimeout( static::MAX_REQUEST_TIMEOUT_SECONDS );

		return $api;
	}

	/**
	 * @param ApiException $e
	 * @throws UnauthorizedException
	 * @throws NotFoundException
	 * @throws ForbiddenException
	 * @throws PersistenceException
	 */
	private function handleApiException( ApiException $e ) {
		switch ( $e->getCode() ) {
			case UnauthorizedException::CODE:
				throw new UnauthorizedException( $e->getMessage() );
				break;
			case NotFoundException::CODE:
				throw new NotFoundException( $e->getMessage() );
				break;
			case ForbiddenException::CODE:
				throw new ForbiddenException( $e->getMessage() );
				break;
			default:
				throw new PersistenceException( $e->getMessage() );
				break;
		}
	}
}
