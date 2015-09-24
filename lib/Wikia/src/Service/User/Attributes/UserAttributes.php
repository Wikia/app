<?php

namespace Wikia\Service\User\Attributes;

use Wikia\Domain\User\Attribute;

class UserAttributes {
	const DEFAULT_ATTRIBUTES = "user_attributes_default_attributes";

	/** @var AttributeService */
	private $attributeService;

	/** @var string[string][string] */
	private $attributes;

	// These are attributes which are updated by clients other than MW. We want to grab these
	// values from the service, rather than MW's user cache, since they may have been updated
	// outside of MW.
	public static $ATTRIBUTES_USED_BY_OUTSIDE_CLIENTS = [ AVATAR_USER_OPTION_NAME, "location" ];

	const CACHE_TTL = 60; // 1 minute

	/**
	 * @Inject({
	 *    Wikia\Service\User\Attributes\AttributeService::class,
	 * })
	 * @param AttributeService $attributeService
	 * @param string[string] $defaultAttributes
	 */
	public function __construct( AttributeService $attributeService ) {
		$this->attributeService = $attributeService;
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
		if ( !isset( $this->attributes[$userId] ) ) {
			$this->attributes[$userId] = [];
			/** @var Attribute $attribute */
			foreach ( $this->attributeService->get( $userId ) as $attribute ) {
				$this->attributes[$userId][$attribute->getName()] = $attribute->getValue();
			};
		}

		return $this->attributes[$userId];
	}

	/**
	 * @param string $userId
	 * @param Attribute $attribute
	 */
	public function setAttribute( $userId, Attribute $attribute ) {
		if ( $this->isAnonUser( $userId ) ) {
			return;
		}

		$this->setAttributeInService( $userId, $attribute );
		$this->setAttributeInCache( $userId, $attribute );
	}

	private function isAnonUser( $userId ) {
		return $userId === 0;
	}

	/**
	 * @param $userId
	 * @param array $attributes
	 */
	public function setAttributesInCache( $userId, array $attributes ) {
		foreach ( $attributes as $attributeKey => $attributeValue ) {
			$this->setAttributeInCache( $userId, new Attribute( $attributeKey, $attributeValue ) );
		}
	}

	/**
	 * @param $userId
	 * @param Attribute $attribute
	 */
	private function setAttributeInCache( $userId, Attribute $attribute ) {
		$this->attributes[$userId][$attribute->getName()] = $attribute->getValue();
	}

	/**
	 * @param $userId
	 * @param Attribute $attribute
	 */
	private function setAttributeInService( $userId, $attribute ) {
		$this->attributeService->set( $userId, $attribute );
	}

	public function deleteAttribute( $userId, Attribute $attribute ) {
		if ( $this->isAnonUser( $userId ) ) {
			return;
		}

		$this->deleteAttributeFromService( $userId, $attribute );
		$this->deleteAttributeFromCache( $userId, $attribute );
	}

	private function deleteAttributeFromCache( $userId, Attribute $attribute ) {
		unset( $this->attributes[$userId][$attribute->getName()] );
	}

	private function deleteAttributeFromService( $userId, Attribute $attribute ) {
		$this->attributeService->delete( $userId, $attribute );
	}

	public static function getCacheKey( $userId ) {
		return wfSharedMemcKey($userId, __CLASS__);
	}
}
