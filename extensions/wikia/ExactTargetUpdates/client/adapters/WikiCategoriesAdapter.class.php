<?php

namespace Wikia\ExactTarget;

use Wikia\ExactTarget\ResourceEnum as Enum;

class WikiCategoriesAdapter extends BaseAdapter {

	private $mapping = [ ];

	public function getCategoriesMapping() {
		return $this->mapping;
	}

	protected function extractResult( $property ) {
		foreach ( $property as $value ) {
			if ( $value->Name === Enum::WIKI_ID ) {
				$wikiId = $value->Value;
			}
			if ( $value->Name === Enum::WIKI_CAT_ID ) {
				$catId = $value->Value;
			}
		}
		$this->mapping[ ] = [ Enum::WIKI_ID => $wikiId, Enum::WIKI_CAT_ID => $catId ];
	}
}
