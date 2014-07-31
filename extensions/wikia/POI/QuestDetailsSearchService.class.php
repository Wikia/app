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

	protected function prepareQuery( $fingerprintId ) {
		$select = $this->getSelect();

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( 'metadata_fingerprint_ids_ss:' . $fingerprintId );

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

	protected function getTitle( &$item ) {
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, 'title_' ) ) {
				return $value;
			}
		}
		return '';
	}

	protected function getArticleCategories( &$item ) {
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, 'categories_' ) ) {
				return $value;
			}
		}
		return '';
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

	protected function getAbstract( &$item ) {
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, 'html_' ) ) {
				return wfShortenText( $value, self::DEFAULT_ABSTRACT_LENGTH, true );
			}
		}
		return '';
	}

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

	protected function getMetadataMap( &$item ) {
		$map = [ ];
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, 'metadata_map_' ) ) {

				if ( $this->endsWith( $key, '_s' ) ) {

					$mapKey = $this->cutPrefixAndSuffix( $key, 'metadata_map_', '_s' );

					$map[ $mapKey ] = $value;

				} else if ( $this->endsWith( $key, '_sr' ) ) {

					$mapKey = $this->cutPrefixAndSuffix( $key, 'metadata_map_', '_sr' );

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