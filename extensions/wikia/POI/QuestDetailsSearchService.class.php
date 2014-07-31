<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/30/14
 * Time: 11:27 AM
 */

use Wikia\Search\Services\EntitySearchService;

class QuestDetailsSearchService extends EntitySearchService {

	const DEFAULT_ABSTRACT_LENGTH = 200;
	const DEFAULT_THUMBNAIL_WIDTH = 200;
	const DEFAULT_THUMBNAIL_HEIGHT = 200;

	protected function prepareQuery( $criteria ) {
		$select = $this->getSelect();

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$conditions = [ ];

		if ( !empty( $criteria[ 'fingerprint' ] ) ) {
			$conditions[ ] = 'metadata_fingerprint_ids_ss:"' . $criteria[ 'fingerprint' ] . '"';
		}
		if ( !empty( $criteria[ 'questId' ] ) ) {
			$conditions[ ] = 'metadata_quest_id_s:"' . $criteria[ 'questId' ] . '"';
		}
		if ( !empty( $criteria[ 'category' ] ) ) {
			$conditions[ ] = 'categories_mv_en:"' . $criteria[ 'category' ] . '"';
		}

		$query = join( ' AND ', $conditions );

		$select->setQuery( $query );

		if( !empty( $criteria[ 'limit' ] ) ) {
			$select->setRows( intval( $criteria[ 'limit' ] ) );
		}

		return $select;
	}

	protected function consumeResponse( $response ) {
		$result = [ ];
		foreach ( $response as $item ) {

			$result[ ] = [
				'id' => $item[ 'pageid' ],
				'title' => $this->getTitle( $item ),
				'url' => $item[ 'url' ],
				'ns' => $item[ 'ns' ],
				'revision' => $this->getRevision( $item ),
				'comments' => $this->getCommentsNumber( $item ),
				'type' => $item[ 'article_type_s' ],
				'categories' => $this->getArticleCategories( $item ),
				'abstract' => $this->getAbstract( $item ),
				'metadata' => $this->getMetadata( $item ),
			];
		}

		$this->addThumbnailsInfo( $result );

		return $result;
	}

	/**
	 * Searching for field with prefix 'title_' (e.g. 'title_fr' or 'title_en')
	 * If there are few fields with such prefix - returns value of first one.
	 * If there are no fields with such prefix - returns empty string.
	 */
	protected function getTitle( &$item ) {
		$title = $this->findFirstValueByKeyPrefix( $item, 'title_' );
		return ( $title == null ) ? '' : $title;
	}

	/**
	 * Searching for field with prefix 'categories_' (e.g. 'categories_mv_en')
	 * If there are few fields with such prefix - returns value of first one.
	 * If there are no fields with such prefix - returns empty array.
	 */
	protected function getArticleCategories( &$item ) {
		$categories = $this->findFirstValueByKeyPrefix( $item, 'categories_' );
		return ( $categories == null ) ? [ ] : $categories;
	}

	/**
	 * Searching for field with prefix 'html_' (e.g. 'html_en' or 'html_fr')
	 * After finding corresponding field - shortening its value.
	 * If there are few fields with such prefix - working with first one value.
	 * If there are no fields with such prefix - returns empty string.
	 */
	protected function getAbstract( &$item ) {
		$html = $this->findFirstValueByKeyPrefix( $item, 'html_' );
		return ( $html == null ) ? '' : wfShortenText( $html, self::DEFAULT_ABSTRACT_LENGTH, true );
	}

	/**
	 * Searches for fields, which starts with prefix 'metadata_' (except 'metadata_map_')
	 * e.g. 'metadata_fingerprint_ids_ss', 'metadata_quest_id_s')
	 * and groups these fields into separate object.
	 *
	 * Prefix 'metadata_' and suffixes '_s' (or '_ss') - will be removed.
	 *
	 * If field will have 'fingerprint_ids' - it will be transformed to 'fingerprints'.
	 *
	 * All fields, which have prefix 'metadata_map_' will be collected using method self::getMetadataMap
	 * and appended to result object - under the key 'map_location'.
	 *
	 * Example:
	 *
	 * Input:
	 * [
	 *      'metadata_fingerprint_ids_ss' => [ 'a', 'b', 'c' ],
	 *      'metadata_quest_id_s' => 'test',
	 *      'metadata_map_location_cr' => '12.3, 45.6',
	 *      'metadata_map_region_s' => 'Test',
	 *      'some_other_field' => 'test',
	 * ]
	 *
	 * Output:
	 * [
	 *      'fingerprints' => [ 'a', 'b', 'c' ],
	 *      'quest_id' => 'test',
	 *      'map_location' => [
	 *          'location_x' => 12.3,
	 *          'location_y' => 45.6,
	 *          'region' => 'Test'
	 *      ]
	 * ]
	 */
	protected function getMetadata( &$item ) {

		$metadata = [ ];
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, 'metadata_' )
				&& !$this->startsWith( $key, 'metadata_map_' )
			) {

				if ( $this->endsWith( $key, '_s' ) ) {

					$metadataKey = $this->cutPrefixAndSuffix( $key, 'metadata_', '_s' );

					$metadata[ $metadataKey ] = $value;

				} else if ( $this->endsWith( $key, '_ss' ) ) {

					$metadataKey = $this->cutPrefixAndSuffix( $key, 'metadata_', '_ss' );

					if ( $metadataKey == 'fingerprint_ids' ) {
						$metadataKey = 'fingerprints';
					}

					$metadata[ $metadataKey ] = $value;

				}
			}
		}

		$metadata[ 'map_location' ] = $this->getMetadataMap( $item );

		return $metadata;
	}

	/**
	 * Searches for fields, which starts with prefix 'metadata_map_'
	 * (e.g. 'metadata_map_location_sr', 'metadata_map_region_s')
	 * and groups these fields into separate object.
	 *
	 * Prefix 'metadata_map_' and suffixes '_s' (or '_sr') - will be removed.
	 *
	 * If field has suffix '_s' - it will be copied as is.
	 *
	 * If field has suffix '_sr' - it will be parsed, in the following way:
	 * '12.3, 45.6' -> will be parsed to float numbers 12.3 and 45.6
	 * first number - will get suffix '_x', and second number will get suffix '_y'.
	 *
	 * Example:
	 *
	 * Input:
	 * [
	 *      'metadata_map_location_cr' => '12.3, 45.6',
	 *      'metadata_map_region_s' => 'Test',
	 *      'some_other_field' => 'test'
	 * ]
	 *
	 * Output:
	 * [
	 *      'location_x' => 12.3,
	 *      'location_y' => 45.6,
	 *      'region' => 'Test'
	 * ]
	 */
	protected function getMetadataMap( &$item ) {
		$map = [ ];
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, 'metadata_map_' ) ) {

				if ( $this->endsWith( $key, '_s' ) ) {

					$mapKey = $this->cutPrefixAndSuffix( $key, 'metadata_map_', '_s' );

					$map[ $mapKey ] = $value;

				} else if ( $this->endsWith( $key, '_sr' ) ) {

					$mapKey = $this->cutPrefixAndSuffix( $key, 'metadata_map_', '_sr' );

					// "12.3, 45.6" => [ "12.3", "45.6" ]
					$parts = preg_split( "/[\s,]+/", $value );
					$x = $parts[ 0 ];
					$y = $parts[ 1 ];

					$map[ $mapKey . '_x' ] = floatval( $x );
					$map[ $mapKey . '_y' ] = floatval( $y );
				}
			}
		}
		return $map;
	}

	protected function getRevision( &$item ) {
		$titles = Title::newFromIDs( $item[ 'pageid' ] );
		$title = $titles[ 0 ];
		$revId = $title->getLatestRevID();
		$rev = Revision::newFromId( $revId );

		$revision = [
			'id' => $revId,
			'user' => $rev->getUserText( Revision::FOR_PUBLIC ),
			'user_id' => $rev->getUser( Revision::FOR_PUBLIC ),
			'timestamp' => wfTimestamp( TS_UNIX, $rev->getTimestamp() )
		];

		return $revision;
	}

	protected function getCommentsNumber( &$item ) {
		$titles = Title::newFromIDs( $item[ 'pageid' ] );
		$title = $titles[ 0 ];
		if ( class_exists( 'ArticleCommentList' ) ) {
			$commentsList = ArticleCommentList::newFromTitle( $title );
			return $commentsList->getCountAllNested();
		}
		return 0;
	}

	protected function addThumbnailsInfo( &$result ) {
		$articleIds = [ ];
		foreach ( $result as &$item ) {
			$articleIds[ ] = $item[ 'id' ];
		}

		$thumbnails = $this->getArticlesThumbnails( $articleIds );

		foreach ( $result as &$item ) {
			$id = $item[ 'id' ];
			$thumbnailProps = $thumbnails[ $id ];
			foreach ( $thumbnailProps as $key => $value ) {
				$item[ $key ] = $value;
			}
		}
	}

	protected function getArticlesThumbnails( $articles, $width = self::DEFAULT_THUMBNAIL_WIDTH, $height = self::DEFAULT_THUMBNAIL_HEIGHT ) {
		$ids = !is_array( $articles ) ? [ $articles ] : $articles;
		$result = [ ];
		if ( $width > 0 && $height > 0 ) {
			$is = $this->getImageServing( $ids, $width, $height );
			//only one image max is returned
			$images = $is->getImages( 1 );
			//parse results
			foreach ( $ids as $id ) {
				$data = [ 'thumbnail' => null, 'original_dimensions' => null ];
				if ( isset( $images[ $id ] ) ) {
					$data[ 'thumbnail' ] = $images[ $id ][ 0 ][ 'url' ];
					$data[ 'original_dimensions' ] = isset( $images[ $id ][ 0 ][ 'original_dimensions' ] ) ?
						$images[ $id ][ 0 ][ 'original_dimensions' ] : null;
				}
				$result[ $id ] = $data;
			}
		}
		return $result;
	}

	protected function findFirstValueByKeyPrefix( &$hash, $prefix ) {
		foreach ( $hash as $key => $value ) {
			if ( $this->startsWith( $key, $prefix ) ) {
				return $value;
			}
		}
		return null;
	}

	protected function getImageServing( $ids, $width, $height ) {
		return new ImageServing( $ids, $width, $height );
	}

	protected function cutPrefixAndSuffix( $str, $prefix, $suffix ) {
		return substr( $str, strlen( $prefix ), strlen( $str ) - strlen( $prefix ) - strlen( $suffix ) );
	}

	protected function startsWith( $str, $prefix ) {
		return $prefix === "" || strpos( $str, $prefix ) === 0;
	}

	protected function endsWith( $str, $suffix ) {
		return $suffix === "" || substr( $str, -strlen( $suffix ) ) === $suffix;
	}
}