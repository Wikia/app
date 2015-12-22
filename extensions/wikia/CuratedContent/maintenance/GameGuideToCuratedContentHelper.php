<?php

class GameGuideToCuratedContentHelper {

	// Data structures
	// GameGuideContent
	// [TagList] - array
	// --[Tag] - title, image_id, categories=>Array of category
	// ----[Categories] - array
	// ------[Category] - title, label, image_id, id
	//
	// CuratedContent
	// [TagList] - array
	// --[Tag] - title, image_id, items=>Array of items(old category)
	// ----[Categories] - array
	// ------[Category] - title, label, image_id, id
	//
	// changes:
	// categories rename to items
	// add Category: to title (ex. Thor -> Category:Thor)
	// change id to article_id
	// add type to every entity (type='category')

	public static function ConvertGameGuideToCuratedContent( $gameGuideContent ) {
		if ( empty( $gameGuideContent ) ) return [ ];
		$app = F::app();
		$categoryName = $app->wg->contLang->getNsText( NS_CATEGORY );
		$curatedContent = [ ];

		foreach ( $gameGuideContent as $GGTag ) {
			if ( !empty( $GGTag ) ) {
				$CCTag = [ ];
				$CCTag[ 'title' ] = $GGTag[ 'title' ];
				$CCTag[ 'image_id' ] = $GGTag[ 'image_id' ];
				if ( !empty( $GGTag[ 'categories' ] ) ) {
					$CCItems = [ ];
					foreach ( $GGTag[ 'categories' ] as $GGCategory ) {

						$CCItem = [ ];

						if ( empty( $GGCategory[ 'title' ] ) || !is_string( $GGCategory[ 'title' ] ) ) {
							continue;
						}

						$CCItem[ 'title' ] = "{$categoryName}" . ":" . $GGCategory[ 'title' ];

						if ( empty( $GGCategory[ 'label' ] ) ) {
							$CCItem[ 'label' ] = $GGCategory[ 'title' ];
						} else {
							$CCItem[ 'label' ] = $GGCategory[ 'label' ];
						}

						if ( empty( $GGCategory[ 'image_id' ] ) || ( $GGCategory[ 'image_id' ] === 0 ) ) {
							$CCItem[ 'image_id' ] = null;
						} else {
							$CCItem[ 'image_id' ] = $GGCategory[ 'image_id' ];
						}
						$CCItem[ 'article_id' ] = $GGCategory[ 'id' ];
						$CCItem[ 'type' ] = 'category';
						array_push( $CCItems, $CCItem );
					}
					$CCTag[ 'items' ] = $CCItems;
				}
				array_push( $curatedContent, $CCTag );
			}
		}
		return $curatedContent;
	}
}