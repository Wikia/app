<?php

namespace Wikia\Service\User\Attributes;

use Wikia\Domain\User\Attribute;

class UserAttributes {
	const DEFAULT_ATTRIBUTES = "user_attributes_default_attributes";

	/** @var AttributeService */
	private $attributeService;

	/** @var string[string][string] */
	private $attributes;

	/** @var string[string] */
	private $defaultAttributes;

	/**
	 * @Inject({
	 *    Wikia\Service\User\Attributes\AttributeService::class,
	 *    Wikia\Service\User\Attributes\UserAttributes::DEFAULT_ATTRIBUTES
	 * })
	 * @param AttributeService $attributeService
	 * @param string[string] $defaultAttributes
	 */
	public function __construct( AttributeService $attributeService, $defaultAttributes ) {
		$this->attributeService = $attributeService;
		$this->defaultAttributes = $defaultAttributes;
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

		if ( !is_null( $this->defaultAttributes[$attributeName] ) ) {
			return  $this->defaultAttributes[$attributeName];
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

		if ( $this->attributeValueAlreadySet( $userId, $attribute ) ) {
			return;
		}

		$this->setAttributeInService( $userId, $attribute );
		$this->setAttributeInCache( $userId, $attribute );
	}

	private function isAnonUser( $userId ) {
		return $userId === 0;
	}

	private function attributeValueAlreadySet( $userId, Attribute $attribute ) {
		return $this->getAttribute( $userId, $attribute->getName() ) === $attribute->getValue();
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

		if ( $this->attributeNotSetForUser( $userId, $attribute ) ) {
			return;
		}

		$this->deleteAttributeFromService( $userId, $attribute );
		$this->deleteAttributeFromCache( $userId, $attribute );
	}

	private function attributeNotSetForUser( $userId, Attribute $attribute ) {
		$this->loadAttributes( $userId );
		return empty( $this->attributes[$userId][$attribute->getName()] );
	}

	private function deleteAttributeFromCache( $userId, Attribute $attribute ) {
		unset( $this->attributes[$userId][$attribute->getName()] );
	}

	private function deleteAttributeFromService( $userId, Attribute $attribute ) {
		$this->attributeService->delete( $userId, $attribute );
	}
}
