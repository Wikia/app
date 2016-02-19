<?php

namespace Wikia\ExactTarget;

class UserEditsAdapter {

	var $edits = [ ];

	public function __construct( $result ) {
		if ( $result->Properties instanceof \stdClass ) {
			$this->extractUserWikiEdits( $result->Properties->Property );
		}
		if ( is_array( $result ) ) {
			$this->extractMultiple( $result );
		}
	}

	public function getEdits() {
		return $this->edits;
	}

	private function extractMultiple( array $properties ) {
		foreach ( $properties as $property ) {
			$this->extractUserWikiEdits( $property->Properties->Property );
		}
	}

	private function extractUserWikiEdits( array $property ) {
		foreach ( $property as $value ) {
			if ( $value->Name === 'user_id' ) {
				$userId = $value->Value;
			}
			if ( $value->Name === 'wiki_id' ) {
				$wikiId = $value->Value;
			}
			if ( $value->Name === 'contributions' ) {
				$userContributions = $value->Value;
			}
		}
		$this->edits[ $userId ][ $wikiId ] = $userContributions;
	}
}
