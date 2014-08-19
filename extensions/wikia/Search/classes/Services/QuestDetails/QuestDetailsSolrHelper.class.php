<?php

class QuestDetailsSolrHelper {

	const DEFAULT_ABSTRACT_LENGTH = 200;

	const DEFAULT_THUMBNAIL_WIDTH = 200;

	const DEFAULT_THUMBNAIL_HEIGHT = 200;

	private $imageDimensionFields = [
		'width',
		'height'
	];

	/**
	 * @var int
	 */
	protected $abstractLength = self::DEFAULT_ABSTRACT_LENGTH;

	/**
	 * @param int $abstractLength
	 */
	public function setAbstractLength( $abstractLength ) {
		$this->abstractLength = $abstractLength;
	}

	public function getRequiredSolrFields() {
		return [ 'pageid', 'title_*', 'url', 'ns', 'article_type_s', 'categories_*', 'html_*', 'metadata_*' ];
	}

	public function consumeResponse( $response, $metadataOnly = false ) {
		$result = [ ];
		foreach ( $response as $item ) {

			if( $metadataOnly ) {
				$id = $item[ 'pageid' ];
				$result[ $id ] = $this->getMetadata( $item );
			} else {
				$resultItem = [
					// These fields must be present always
					'id' => $item[ 'pageid' ],
					'title' => $this->findFirstValueByKeyPrefix( $item, 'title_', '' ),
					'url' => $item[ 'url' ],
					'ns' => $item[ 'ns' ],
					'revision' => $this->getRevision( $item )
				];

				$comments = $this->getCommentsNumber( $item );
				if( isset( $comments ) ) {
					$resultItem[ 'comments' ] = $comments;
				}

				$type = $item[ 'article_type_s' ];
				$this->addIfNotEmpty( $resultItem, 'type', $type );

				$categories = $this->findFirstValueByKeyPrefix( $item, 'categories_', [ ] );
				$this->addIfNotEmpty( $resultItem, 'categories', $categories );

				$abstract = $this->getAbstract( $item );
				$this->addIfNotEmpty( $resultItem, 'abstract', $abstract );

				$metadata = $this->getMetadata( $item );
				$this->addIfNotEmpty( $resultItem, 'metadata', $metadata );

				$result[ ] = $resultItem;
			}
		}

		if( !$metadataOnly ) {
			$this->addThumbnailsInfo( $result );
		}

		return $result;
	}

	/**
	 * Searching for field with prefix 'html_' (e.g. 'html_en' or 'html_fr')
	 * After finding corresponding field - shortening its value.
	 * If there are few fields with such prefix - working with first one value.
	 * If there are no fields with such prefix - returns empty string.
	 */
	protected function getAbstract( $item ) {
		$html = $this->findFirstValueByKeyPrefix( $item, 'html_', '' );
		return wfShortenText( $html, $this->abstractLength, true );
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
	protected function getMetadata( $item ) {

		$metadata = [ ];
		foreach ( $item as $key => $value ) {
			if ( startsWith( $key, 'metadata_' )
				&& !startsWith( $key, 'metadata_map_' )
			) {

				if ( endsWith( $key, '_s' ) ) {

					$metadataKey = $this->cutPrefixAndSuffix( $key, 'metadata_', '_s' );

					$this->addIfNotEmpty( $metadata, $metadataKey, $value );

				} else if ( endsWith( $key, '_ss' ) ) {

					$metadataKey = $this->cutPrefixAndSuffix( $key, 'metadata_', '_ss' );

					if ( $metadataKey == 'fingerprint_ids' ) {
						$metadataKey = 'fingerprints';
					}

					$this->addIfNotEmpty( $metadata, $metadataKey, $value );
				}
			}
		}

		$metadataMap = $this->getMetadataMap( $item );

		if( !empty( $metadataMap ) ) {
			$metadata[ 'map_location' ] = $metadataMap;
		}

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
	protected function getMetadataMap( $item ) {
		$map = [ ];
		foreach ( $item as $key => $value ) {
			if ( startsWith( $key, 'metadata_map_' ) ) {

				if ( endsWith( $key, '_s' ) ) {

					$mapKey = $this->cutPrefixAndSuffix( $key, 'metadata_map_', '_s' );

					$this->addIfNotEmpty( $map, $mapKey, $value );

				} else if ( endsWith( $key, '_sr' ) ) {

					$mapKey = $this->cutPrefixAndSuffix( $key, 'metadata_map_', '_sr' );

					if( !empty( $value ) ) {
						$coordinates = $this->parseCoordinates( $value );

						$map[ 'latitude' ] = $coordinates[ 'x' ];
						$map[ 'longitude' ] = $coordinates[ 'y' ];
					}
				}
			}
		}
		return $map;
	}

	/**
	 * Parsing string with coordinates
	 * @param $str - e.g. "12.3, 45.6"
	 * @return array - e.g. [ 'x' => 12.3, 'y' => 45.6 ]
	 * @throws Exception - when string has invalid format
	 */
	protected function parseCoordinates( $str ) {

		// e.g. matches: "12.3, 45.6"
		if(preg_match( '/-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?/i', $str )) {

			// "12.3, 45.6" => [ "12.3", "45.6" ]
			$parts = preg_split( "/\s*,\s*/", $str );

			$x = $parts[ 0 ];
			$y = $parts[ 1 ];

			return [
				'x' => floatval( $x ),
				'y' => floatval( $y )
			];
		}
		throw new Exception( 'Invalid format of string with coordinates: ' . $str );
	}

	protected function getRevision( $item ) {
		$titles = Title::newFromIDs( $item[ 'pageid' ] );
		if( empty( $titles ) ) {
			return null;
		}
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

	protected function getCommentsNumber( $item ) {
		$titles = Title::newFromIDs( $item[ 'pageid' ] );
		if( empty( $titles ) ) {
			return null;
		}
		$title = $titles[ 0 ];
		if ( class_exists( 'ArticleCommentList' ) ) {
			$commentsList = ArticleCommentList::newFromTitle( $title );
			return $commentsList->getCountAllNested();
		}
		return null;
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
				if( !empty( $value ) ) {
					$item[ $key ] = $value;
				}
			}
		}
	}

	protected function getArticlesThumbnails( $articles ) {
		$ids = !is_array( $articles ) ? [ $articles ] : $articles;
		$result = [ ];
		if ( self::DEFAULT_THUMBNAIL_WIDTH > 0 && self::DEFAULT_THUMBNAIL_HEIGHT > 0 ) {
			$is = $this->getImageServing( $ids, self::DEFAULT_THUMBNAIL_WIDTH, self::DEFAULT_THUMBNAIL_HEIGHT );
			//only one image max is returned
			$images = $is->getImages( 1 );
			//parse results
			foreach ( $ids as $id ) {
				$data = [ 'thumbnail' => null, 'original_dimensions' => null ];
				if ( isset( $images[ $id ] ) ) {
					$data[ 'thumbnail' ] = $images[ $id ][ 0 ][ 'url' ];
					if ( is_array( $images[ $id ][ 0 ][ 'original_dimensions' ] ) ) {
						array_walk( $images[ $id ][ 0 ][ 'original_dimensions' ], [ $this, 'normalizeDimension' ] );

						$data[ 'original_dimensions' ] = $images[ $id ][ 0 ][ 'original_dimensions' ];
					} else {
						$data[ 'original_dimensions' ] = null;
					}
				}
				$result[ $id ] = $data;
			}
		}
		return $result;
	}

	/**
	 * Normalizes (converts to integer) $dimension passed to the method, stored
	 * under $key.
	 * Meant to be used as callable in array_walk
	 *
	 * @param $dimension
	 * @param $key
	 */
	protected function normalizeDimension( &$dimension, $key ) {
		if ( in_array( $key, $this->imageDimensionFields ) ) {
			$dimension = intval( $dimension );
		}
	}

	protected function findFirstValueByKeyPrefix( $hash, $prefix, $defaultValue = null ) {
		foreach ( $hash as $key => $value ) {
			if ( startsWith( $key, $prefix ) ) {
				return $value;
			}
		}
		return $defaultValue;
	}

	protected function getImageServing( $ids, $width, $height ) {
		return new ImageServing( $ids, $width, $height );
	}

	protected function cutPrefixAndSuffix( $str, $prefix, $suffix ) {
		$prefixLen = mb_strlen( $prefix );
		$suffixLen = mb_strlen( $suffix );
		$strLen = mb_strlen( $str );
		return substr( $str, $prefixLen, $strLen - $prefixLen - $suffixLen );
	}

	protected function addIfNotEmpty( &$hashMap, $key, $value ) {
		if( !empty( $value ) ) {

			if( is_array( $value ) ) {

				$cleanedArray = $this->removeEmptyItems( $value );

				if( !empty( $cleanedArray ) ) {
					$hashMap[ $key ] = $cleanedArray;
				}

			} else {
				$hashMap[ $key ] = $value;
			}
		}
	}

	protected function removeEmptyItems( $array ) {
		$cleanedArray = [ ];

		foreach( $array as $key => $value ) {
			if( !empty( $value ) ) {
				$cleanedArray[ $key ] = $value;
			}
		}

		return $cleanedArray;
	}
} 