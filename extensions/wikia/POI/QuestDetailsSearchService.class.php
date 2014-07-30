<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/30/14
 * Time: 11:27 AM
 */

use Wikia\Search\Services\EntitySearchService;

class QuestDetailsSearchService extends EntitySearchService {

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
				'metadata' => $this->getMetadata( $item ),
			];
		}
		return $result;
	}

	/**
	 * @param $item
	 * @return string
	 */
	protected function getTitle( &$item ) {
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, 'title_' ) ) {
				return $value;
			}
		}
		return '';
	}

	protected function getMetadata( &$item ) {
		$metadata = [ ];

		$PREFIX_METADATA = 'metadata_';
		$LENGTH_PREFIX_METADATA = strlen( $PREFIX_METADATA );

		$SUFFIX_S = '_s';
		$LENGTH_SUFFIX_S = strlen( $SUFFIX_S );

		$SUFFIX_SS = '_ss';
		$LENGTH_SUFFIX_SS = strlen( $SUFFIX_SS );

		$SUFFIX_SR = '_sr';
		$LENGTH_SUFFIX_SR = strlen( $SUFFIX_SR );

		$metadataKeys = [ ];
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, $PREFIX_METADATA ) ) {
				$metadataKeys[ ] = $key;
			}
		}

		foreach ( $metadataKeys as $key ) {
			$value = $item[ $key ];
			
			if ( $this->endsWith( $key, $SUFFIX_S ) ) {

				$metadataKey =
					substr( $key, $LENGTH_PREFIX_METADATA, strlen( $key ) - $LENGTH_PREFIX_METADATA - $LENGTH_SUFFIX_S );
				$metadata[ $metadataKey ] = $value;

			} else if ( $this->endsWith( $key, $SUFFIX_SS ) ) {

				$metadataKey =
					substr( $key, $LENGTH_PREFIX_METADATA, strlen( $key ) - $LENGTH_PREFIX_METADATA - $LENGTH_SUFFIX_SS );
				$metadata[ $metadataKey ] = $value;

			} else if ( $this->endsWith( $key, $SUFFIX_SR ) ) {

				$metadataKey =
					substr( $key, $LENGTH_PREFIX_METADATA, strlen( $key ) - $LENGTH_PREFIX_METADATA - $LENGTH_SUFFIX_SR );

				$parts = preg_split( "/[\s,]+/", $value );
				$x = $parts[ 0 ];
				$y = $parts[ 1 ];

				$metadata[ $metadataKey ] = [
					'location_x' => floatval( $x ),
					'location_y' => floatval( $y ),
				];
			}
		}

		return $metadata;
	}

	protected function startsWith( $haystack, $needle ) {
		return $needle === "" || strpos( $haystack, $needle ) === 0;
	}

	protected function endsWith( $haystack, $needle ) {
		return $needle === "" || substr( $haystack, -strlen( $needle ) ) === $needle;
	}
} 