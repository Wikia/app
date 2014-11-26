<?php

class GameGuideToCuratedContentHelper {



	//Data structures
	//GameGuideContent
	//[TagList] - array
	//--[Tag] - title, image_id, categories=>Array of category
	//----[Categories] - array
	//------[Category] - title, label, image_id, id
	//
	//CuratedContent
	//[TagList] - array
	//--[Tag] - title, image_id, items=>Array of items(old category)
	//----[Categories] - array
	//------[Category] - title, label, image_id, id
	//
	//changes:
	//categories rename to items
	//add Category: to title (ex. Thor -> Category:Thor)
	//change id to article_id
	//add type to every entity (type='category')

	public static function ConvertGameGuideToCuratedContent( $gameGuideContent ) {
		if ( empty( $gameGuideContent ) ) return [ ];

		foreach ( $gameGuideContent as &$tagArray ) {
			if ( !empty( $tagArray ) ) {
				$tagArray[ 'items' ] = $tagArray[ 'categories' ];
				unset( $tagArray[ 'categories' ] );
				foreach ( $tagArray[ 'items' ] as &$articleArray ) {
					if ( empty( $articleArray[ 'label' ] ) ) {
						$articleArray[ 'label' ] = $articleArray[ 'title' ];
					}
					$articleArray[ 'title' ] = "Category:" . $articleArray[ 'title' ];
					$articleArray[ 'article_id' ] = $articleArray[ 'id' ];
					unset( $articleArray[ 'id' ] );
					$articleArray[ 'type' ] = 'category';
				}
			}
		}
		return $gameGuideContent;
	}
}