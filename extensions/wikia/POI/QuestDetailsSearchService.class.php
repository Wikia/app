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
				'type' => $item[ 'article_type_s' ],
				'abstract' => $this->getAbstract( $item ),
				'metadata' => $this->getMetadata( $item ),
			];
		}
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

	protected function getRevision( &$item ) {
		$t = Title::newFromIDs( $item[ 'pageid' ] );
		$revId = $t[ 0 ]->getLatestRevID();
		$rev = Revision::newFromId( $revId );

		$revision = [
			'id' => $revId,
			'user' => $rev->getUserText( Revision::FOR_PUBLIC ),
			'user_id' => $rev->getUser( Revision::FOR_PUBLIC ),
			'timestamp' => wfTimestamp( TS_UNIX, $rev->getTimestamp() )
		];

		return $revision;
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

					$metadataKey = substr(
						$key,
						strlen( 'metadata_' ),
						strlen( $key ) - strlen( 'metadata_' ) - strlen( '_s' )
					);

					$metadata[ $metadataKey ] = $value;

				} else if ( $this->endsWith( $key, '_ss' ) ) {

					$metadataKey = substr(
						$key,
						strlen( 'metadata_' ),
						strlen( $key ) - strlen( 'metadata_' ) - strlen( '_ss' )
					);

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

					$mapKey = substr(
						$key,
						strlen( 'metadata_map_' ),
						strlen( $key ) - strlen( 'metadata_map_' ) - strlen( '_s' )
					);

					$map[ $mapKey ] = $value;

				} else if ( $this->endsWith( $key, '_sr' ) ) {

					$mapKey = substr(
						$key,
						strlen( 'metadata_map_' ),
						strlen( $key ) - strlen( 'metadata_map_' ) - strlen( '_sr' )
					);

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

	protected function startsWith( $haystack, $needle ) {
		return $needle === "" || strpos( $haystack, $needle ) === 0;
	}

	protected function endsWith( $haystack, $needle ) {
		return $needle === "" || substr( $haystack, -strlen( $needle ) ) === $needle;
	}
}