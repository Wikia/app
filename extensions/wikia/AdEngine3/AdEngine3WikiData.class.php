<?php

class AdEngine3WikiData {
	public static function getVerticalName( $oldWikiVertical, $newWikiVertical ) {
		if ( $oldWikiVertical === 'Wikia' ) {
			return 'wikia';
		}

		$mapping = [
			'other' => 'life',
			'tv' => 'ent',
			'games' => 'gaming',
			'books' => 'ent',
			'comics' => 'ent',
			'lifestyle' => 'life',
			'music' => 'ent',
			'movies' => 'ent'
		];

		$newVerticalName = strtolower( $newWikiVertical );
		if ( !empty($mapping[$newVerticalName]) ) {
			return $mapping[$newVerticalName];
		}

		return 'error';
	}

	public static function getWikiCategories( WikiFactoryHub $wikiFactoryHub, $cityId ) {
		$oldWikiCategories = $wikiFactoryHub->getWikiCategoryNames( $cityId, false );
		$newWikiCategories = $wikiFactoryHub->getWikiCategoryNames( $cityId, true );

		if ( is_array( $oldWikiCategories ) && is_array( $newWikiCategories ) ) {
			$wikiCategories = array_merge( $oldWikiCategories, $newWikiCategories );
		} else {
			if ( is_array( $oldWikiCategories ) ) {
				$wikiCategories = $oldWikiCategories;
			} else {
				if ( is_array( $newWikiCategories ) ) {
					$wikiCategories = $newWikiCategories;
				} else {
					$wikiCategories = [ ];
				}
			}
		}

		return array_unique( $wikiCategories );
	}
}
