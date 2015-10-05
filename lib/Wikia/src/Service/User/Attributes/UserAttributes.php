<?php

namespace Wikia\Service\User\Attributes;

use Doctrine\Common\Cache\CacheProvider;
use Wikia\Domain\User\Attribute;
use Wikia\Logger\Loggable;

class UserAttributes {

	use Loggable;

	const CACHE_PROVIDER = "user_attributes_cache_provider";

	/** @var CacheProvider */
	private $cache;

	/** @var AttributeService */
	private $attributeService;

	/** @var string[string][string] */
	private $attributes;

	// These are attributes which are updated by clients other than MW. We want to grab these
	// values from the service, rather than MW's user cache, since they may have been updated
	// outside of MW.
	public static $ATTRIBUTES_USED_BY_OUTSIDE_CLIENTS = [ AVATAR_USER_OPTION_NAME, "location" ];

	const CACHE_TTL = 300; // 5 minute

	/**
	 * @Inject({
	 *    Wikia\Service\User\Attributes\AttributeService::class,
	 * 	  Wikia\Service\User\Attributes\UserAttributes::CACHE_PROVIDER,
	 * })
	 * @param AttributeService $attributeService
	 * @param CacheProvider $cache,
	 */
	public function __construct( AttributeService $attributeService, CacheProvider $cache ) {
		$this->attributeService = $attributeService;
		$this->cache = $cache;
		$this->attributes = [];
	}

	public function getAttributes( $userId ) {
		return $this->loadAttributes( $userId );
	}

	public function getAttribute( $userId, $attributeName, $default = null ) {
		$attributes = $this->loadAttributes( $userId );

		if ( !is_null( $attributes[$attributeName] ) ) {
			return $attributes[$attributeName];
		}

		return $default;
	}

	private function loadAttributes( $userId ) {

		if ( isset( $this->attributes[$userId] ) ) {
			return $this->attributes[$userId];
		}

		$attributes = $this->loadFromMemcache( $userId );
		if ( $attributes === false ) {
			$attributes = [];
			/** @var Attribute $attribute */
			foreach ( $this->attributeService->get( $userId ) as $attribute ) {
				$attributes[$attribute->getName()] = $attribute->getValue();
			};
			$this->logAttributeServiceRequest( $userId );
			$this->setInMemcache( $userId, $attributes );
		}

		$this->attributes[$userId] = $attributes;

		return $attributes;
	}

	private function loadFromMemcache( $userId ) {
		return $this->cache->fetch( $userId );
	}

	private function setInMemcache( $userId, $attributes ) {
		$this->cache->save( $userId, $attributes, self::CACHE_TTL );
	}

	/**
	 * @param string $userId
	 * @param Attribute $attribute
	 */
	public function setAttribute( $userId, Attribute $attribute ) {
		$this->setInService( $userId, $attribute );
		$this->setInInstanceCache( $userId, $attribute );
		$this->setInMemcache( $userId, $this->attributes[$userId] );
	}

	/**
	 * @param $userId
	 * @param Attribute $attribute
	 */
	private function setInService( $userId, $attribute ) {
		$this->attributeService->set( $userId, $attribute );
	}

	/**
	 * @param $userId
	 * @param Attribute $attribute
	 */
	private function setInInstanceCache( $userId, Attribute $attribute ) {
		$this->attributes[$userId][$attribute->getName()] = $attribute->getValue();
	}


	public function deleteAttribute( $userId, Attribute $attribute ) {
		$this->deleteFromService( $userId, $attribute );
		$this->deleteFromInstanceCache( $userId, $attribute );
		$this->setInMemcache( $userId, $this->attributes[$userId] );
	}

	private function deleteFromService( $userId, Attribute $attribute ) {
		$this->attributeService->delete( $userId, $attribute );
	}

	private function deleteFromInstanceCache( $userId, Attribute $attribute ) {
		unset( $this->attributes[$userId][$attribute->getName()] );
	}

	public function clearCache( $userId ) {
		$this->cache->delete( $userId );
		unset( $this->attributes[$userId] );
	}

	private function logAttributeServiceRequest( $userId ) {
		$this->info( 'USER_ATTRIBUTES request_from_service', [
			'userId' => $userId
		] );
	}
}
