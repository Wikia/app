<?php

namespace Wikia\ExactTarget;

class UserGroupsAdapter {

	var $groups = [ ];

	public function __construct( $result ) {
		if ( is_array( $result ) ) {
			$this->extractMultiple( $result );
		}
	}

	public function getUserGroups() {
		return $this->groups;
	}

	private function extractMultiple( array $properties ) {
		foreach ( $properties as $property ) {
			$this->extractUserGroups( $property->Properties->Property );
		}
	}

	private function extractUserGroups( array $property ) {
		foreach ( $property as $value ) {
			switch ( $value->Name ) {
				case 'ug_user':
					$userId = $value->Value;
					break;
				case 'ug_group':
					$userGroup = $value->Value;
					break;
			}
		}
		$this->groups[ $userId ][ ] = $userGroup;
	}
}
