<?php

namespace Wikia\Persistence\User\Attributes;

use Swagger\Client\ApiException;
use Swagger\Client\User\Attributes\Api\UsersAttributesApi;
use Wikia\Domain\User\Attribute;
use Wikia\Service\NotFoundException;
use Wikia\Service\PersistenceException;
use Wikia\Service\Swagger\ApiProvider;
use Wikia\Service\UnauthorizedException;

class AttributePersistenceSwagger implements AttributePersistence {
	const SERVICE_NAME = "user-attribute";

	/** @var ApiProvider */
	private $apiProvider;

	public function __construct( ApiProvider $apiProvider ) {
		$this->apiProvider = $apiProvider;
	}

	/**
	 * @param int $userId
	 * @param Attribute $attribute
	 * @return true success, false or exception otherwise
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function save( $userId, $attribute ) {
		try {
			$this->getApi( $userId )->saveAttributeForUser( $userId, $attribute->getName(), $attribute->getValue() );
			return true;
		} catch (ApiException $e) {
			$this->handleApiException($e);
			return false;
		}
	}

	/**
	 * Get the user's attributes.
	 *
	 * @param int $userId
	 * @throws UnauthorizedException
	 * @throws PersistenceException
	 * @return Attribute[]
	 */
	public function get( $userId ) {

		$attributes = [];
		$api = $this->getApi( $userId );
		try {
			foreach ( $api->getAllAttributesForUser( $userId )->getEmbedded()->getProperties() as $attribute ) {
				$attributes[] = new Attribute( $attribute->getName(), $attribute->getValue() );
			}
		} catch ( ApiException $e ) {
			$this->handleApiException( $e );
		}

		return $attributes;
	}

	/**
	 * @param $userId
	 * @return UsersAttributesApi
	 */
	private function getApi( $userId ) {
		return $this->apiProvider->getAuthenticatedApi( self::SERVICE_NAME, $userId, UsersAttributesApi::class );
	}

	/**
	 * @param ApiException $e
	 * @throws UnauthorizedException
	 * @throws NotFoundException
	 * @throws PersistenceException
	 */
	private function handleApiException( ApiException $e ) {
		switch ( $e->getCode() ) {
			case UnauthorizedException::CODE:
				throw new UnauthorizedException();
				break;
			case NotFoundException::CODE:
				break;
			default:
				throw new PersistenceException( $e->getMessage() );
				break;
		}
	}
}
