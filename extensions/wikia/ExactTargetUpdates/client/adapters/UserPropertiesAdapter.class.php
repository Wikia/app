<?php

namespace Wikia\ExactTarget;

class UserPropertiesAdapter {

	var $properties = [ ];

	public function __construct( $result ) {
		if ( is_array( $result ) ) {
			$this->extractMultiple( $result );
		}
	}

	public function getUserProperties() {
		return $this->properties;
	}

	private function extractMultiple( array $properties ) {
		foreach ( $properties as $property ) {
			$this->extractUserGroups( $property->Properties->Property );
		}
	}

	private function extractUserGroups( array $property ) {
		foreach ( $property as $value ) {
			switch ( $value->Name ) {
				case 'up_user':
					$userId = $value->Value;
					break;
				case 'up_property':
					$property = $value->Value;
					break;
				case 'up_value':
					$value = $value->Value;
					break;
			}
		}
		$this->properties[ $userId ][ $property ] = $value;
	}
}
