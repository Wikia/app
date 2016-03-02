<?php

namespace Wikia\ExactTarget;

use Wikia\ExactTarget\ResourceEnum as Enum;

class WikiCategoriesAdapter {

	private $mapping = [ ];

	public function __construct( $result ) {
		if ( $result->Properties instanceof \stdClass ) {
			$this->extractCategoriesMapping( $result->Properties->Property );
		}
		if ( is_array( $result ) ) {
			$this->extractMultiple( $result );
		}
	}

	public function getCategoriesMapping() {
		return $this->mapping;
	}

	private function extractMultiple( array $properties ) {
		foreach ( $properties as $property ) {
			$this->extractCategoriesMapping( $property->Properties->Property );
		}
	}

	private function extractCategoriesMapping( array $property ) {
		foreach ( $property as $value ) {
			if ( $value->Name === Enum::WIKI_CITY_ID ) {
				$cityId = $value->Value;
			}
			if ( $value->Name === Enum::WIKI_CAT_ID ) {
				$catId = $value->Value;
			}
		}
		$this->mapping[ $cityId ][ ] = $catId;
	}
}
