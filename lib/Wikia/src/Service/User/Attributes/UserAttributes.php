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
		return $this->load( $userId );
	}

	public function getAttribute( $userId, $attributeName ) {
		$attributes = $this->load( $userId );
		return empty( $attributes[$attributeName] ) ? null : $attributes[$attributeName];
	}

	private function load( $userId ) {
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
	public function saveAttribute( $userId, $attribute ) {
		if ( $userId == 0 ) {
			return;
		}

		$this->attributeService->setAttribute( $userId, $attribute );
		$this->attributes[$userId][$attribute->getName()] = $attribute->getValue();
	}
}
