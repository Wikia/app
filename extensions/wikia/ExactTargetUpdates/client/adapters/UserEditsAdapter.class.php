<?php

namespace Wikia\ExactTarget;

use Wikia\ExactTarget\ResourceEnum as Enum;

class UserEditsAdapter extends BaseAdapter{

	private $edits = [ ];

	public function getEdits() {
		return $this->edits;
	}

	protected function extractResult( $property ) {
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
