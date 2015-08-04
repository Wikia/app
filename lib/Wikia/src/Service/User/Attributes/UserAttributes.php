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

		if ( !empty( $attributes[$attributeName] ) ) {
			return $attributes[$attributeName];
		}

		if ( !empty( $this->defaultAttributes[$attributeName] ) ) {
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
	public function setAttribute( $userId, $attribute ) {
		if ( $this->isAnonUser( $userId ) ) {
			return;
		}

		$this->loadAttributes( $userId );
		$this->setAttributeInService( $userId, $attribute );
		$this->setAttributeInCache( $userId, $attribute );

	}

	private function isAnonUser( $userId ) {
		return $userId === 0;
	}

	/**
	 * @param $userId
	 * @param Attribute $attribute
	 */
	private function setAttributeInService( $userId, $attribute ) {
		$this->attributeService->set( $userId, $attribute );
	}

	/**
	 * @param $userId
	 * @param Attribute $attribute
	 */
	private function setAttributeInCache( $userId, $attribute ) {
		$this->attributes[$userId][$attribute->getName()] = $attribute->getValue();
	}

	public function deleteAttribute( $userId, $attribute ) {
		$this->attributeService->delete( $userId, $attribute );
	}
}
