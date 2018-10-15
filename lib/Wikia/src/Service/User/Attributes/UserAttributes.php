<?php

namespace Wikia\Service\User\Attributes;

use Wikia\Domain\User\Attribute;
use Wikia\Logger\Loggable;

class UserAttributes {

	use Loggable;

	// Attributes which the service returns, but treats as immutable and therefore we
	// shouldn't attempt to save as the service will return a 403.
	const READ_ONLY_ATTRIBUTES = [ 'username' ];

	/** @var AttributeService */
	private $attributeService;

	/** @var string[string][string] */
	private $attributes;

	/** @var string[string] */
	private $defaultAttributes;

	/** @var Attribute[] $changedAttributes */
	private $changedAttributes;

	/**
	 * @param AttributeService $attributeService
	 * @param string[string] $defaultAttributes
	 */
	public function __construct( AttributeService $attributeService, $defaultAttributes ) {
		$this->attributeService = $attributeService;
		$this->defaultAttributes = $defaultAttributes;
		$this->attributes = [];
		$this->changedAttributes = [];
	}

	public function getAttributes( $userId ) {
		return $this->loadAttributes( $userId );
	}

	public function getAttribute( $userId, $attributeName, $default = null ) {
		$attributes = $this->loadAttributes( $userId );

		if ( isset( $attributes[$attributeName] ) ) {
			return $attributes[$attributeName];
		}

		if ( isset( $this->defaultAttributes[$attributeName] ) ) {
			return  $this->defaultAttributes[$attributeName];
		}

		return $default;
	}

	private function loadAttributes( $userId ) {

		// By returning an empty array here for anonymous users, we prevent an unnecessary
		// call to the attribute service Anon users will just use default values for attributes.
		if ( $userId == 0 ) {
			return [];
		}

		if ( isset( $this->attributes[$userId] ) ) {
			return $this->attributes[$userId];
		}

		$attributes = [];
		/** @var Attribute $attribute */
		foreach ( $this->attributeService->get( $userId ) as $attribute ) {
			$attributes[$attribute->getName()] = $attribute->getValue();
		}
		$this->logAttributeServiceRequest( $userId );

		$this->attributes[$userId] = $attributes;

		return $attributes;
	}

	/**
	 * @param string $userId
	 * @param Attribute $attribute
	 */
	public function setAttribute( $userId, Attribute $attribute ) {
		$this->loadAttributes( $userId );

		$name = $attribute->getName();
		$value = $attribute->getValue();

		// If attribute value is null and default exists, set value to default
		if ( is_null( $value ) && isset( $this->defaultAttributes[$name] ) ) {
			$attribute->setValue( $this->defaultAttributes[$name] );
		}

		// SRE-97: Only set the attribute if it was not set before or the value was changed
		if ( !isset( $this->attributes[$userId][$name] ) || $this->attributes[$userId][$name] !== $value ) {
			$this->changedAttributes[$name] = $attribute;
			$this->attributes[$userId][$name] = $attribute->getValue();
		}
	}

	public function save( $userId ) {
		$savedAttributes = [];

		foreach( $this->changedAttributes as $name => $attribute ) {
			$value = $attribute->getValue();

			if ( $this->isReadOnlyAttribute( $name ) ) {
				continue;
			}

			if ( $this->attributeShouldBeSaved( $name, $value ) ) {
				$savedAttributes[$name] = $value;
				if ( $name == 'avatar' ) {
					$this->logIfBadAvatarVal( $value, $userId );
				}
			} elseif ( $this->attributeShouldBeDeleted( $name, $value ) ) {
				$this->deleteFromService( $userId, $attribute );
			}
		}

		$this->attributeService->set( $userId, $savedAttributes );
	}

	private function isReadOnlyAttribute( $name ) {
		return in_array( $name, self::READ_ONLY_ATTRIBUTES );
	}

	private function logIfBadAvatarVal( $value, $userId ) {

		if ( $value == "" || preg_match( '/^http/', $value ) ) {
			return;
		}

		$this->error( 'USER_ATTRIBUTES saving_bad_avatar_val', [
			'userId' => $userId,
			'avatar_val' => $value,
			'exception' => new \Exception()
		] );
	}

	/**
	 * Returns true if either is true:
	 * 1.) No default for the attribute and the value is either not false or not null
	 * 2.) Value is different than the default
	 * @param $name
	 * @param $value
	 * @return bool
	 */
	private function attributeShouldBeSaved( $name, $value ): bool {
		if ( !isset( $this->defaultAttributes[$name] ) ) {
			return $value !== false && $value !== null;
		}

		return $value !== $this->defaultAttributes[$name];
	}

	private function attributeShouldBeDeleted( $name, $value ) {
		return (
			( isset( $this->defaultAttributes[$name] ) && $value == $this->defaultAttributes[$name] ) ||
			is_null( $value )
		);
	}

	public function deleteAttribute( $userId, Attribute $attribute ) {
		$this->loadAttributes( $userId );

		$this->deleteFromService( $userId, $attribute );
		$this->deleteFromInstanceCache( $userId, $attribute );
	}

	private function deleteFromService( $userId, Attribute $attribute ) {
		$this->attributeService->delete( $userId, $attribute );
	}

	private function deleteFromInstanceCache( $userId, Attribute $attribute ) {
		unset( $this->attributes[$userId][$attribute->getName()] );
	}

	public function clearCache( $userId ) {
		unset( $this->attributes[$userId] );
	}

	private function logAttributeServiceRequest( $userId ) {
		$this->info( 'USER_ATTRIBUTES request_from_service', [
			'userId' => $userId
		] );
	}
}
