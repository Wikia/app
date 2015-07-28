<?php

namespace Wikia\Service\User\Attributes;

use Wikia\Domain\User\Attribute;

class UserAttributes {

	/** @var AttributeService */
	private $attributeService;

	/** @var string[string][string] */
	private $attributes;

	/**
	 * @Inject({
	 *    Wikia\Service\User\Attributes\AttributeService::class,
	 * })
	 * @param AttributeService $attributeService
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
		return empty( $attributes[$attributeName] ) ? $default : $attributes[$attributeName];
	}

	private function loadAttributes( $userId ) {
		if ( !isset( $this->attributes[$userId] ) ) {
			$this->attributes[$userId] = [];
			/** @var Attribute $attribute */
			foreach ( $this->attributeService->getAttributes( $userId ) as $attribute ) {
				$this->attributes[$userId][ $attribute->getName()] = $attribute->getValue();
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
		return $userId == 0;
	}

	/**
	 * @param $userId
	 * @param Attribute $attribute
	 */
	private function setAttributeInService( $userId, $attribute ) {
		$this->attributeService->setAttribute( $userId, $attribute );
	}

	/**
	 * @param $userId
	 * @param Attribute $attribute
	 */
	private function setAttributeInCache( $userId, $attribute ) {
		$this->attributes[$userId][$attribute->getName()] = $attribute->getValue();
	}
}
