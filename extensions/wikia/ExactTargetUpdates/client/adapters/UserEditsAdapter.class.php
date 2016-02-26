<?php

namespace Wikia\ExactTarget;

use Wikia\ExactTarget\ResourceEnum as Enum;

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
			if ( $value->Name === Enum::USER_ID ) {
				$userId = $value->Value;
			}
			if ( $value->Name === Enum::USER_WIKI_ID ) {
				$wikiId = $value->Value;
			}
			if ( $value->Name === Enum::USER_WIKI_FIELD_CONTRIBUTIONS ) {
				$userContributions = $value->Value;
			}
		}
		$this->edits[ $userId ][ $wikiId ] = $userContributions;
	}
}
