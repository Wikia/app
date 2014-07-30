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

		$metadataKeys = [];
		foreach ( $item as $key => $value ) {
			if ( $this->startsWith( $key, 'metadata_' ) ) {
				$metadataKeys[] = $key;
			}
		}

		foreach($metadataKeys as $key) {
			$value = $item[$key];
			if ( $this->endsWith( $key, '_s' ) ) {

				$metadataKey = substr( $key, strlen( 'metadata_' ), strlen( $key ) - strlen( 'metadata_' ) - strlen( '_s' ) );
				$metadata[ $metadataKey ] = $value;

			} else if ( $this->endsWith( $key, '_ss' ) ) {

				$metadataKey = substr( $key, strlen( 'metadata_' ), strlen( $key ) - strlen( 'metadata_' ) - strlen( '_ss' ) );
				$metadata[ $metadataKey ] = $value;

			} else if ( $this->endsWith( $key, '_sr' ) ) {

				$metadataKey = substr( $key, strlen( 'metadata_' ), strlen( $key ) - strlen( 'metadata_' ) - strlen( '_sr' ) );

				$parts = preg_split("/[\s,]+/", $value);
				$x = $parts[0];
				$y = $parts[1];

				$metadata[$metadataKey] = [
					'location_x' => floatval($x),
					'location_y' => floatval($y),
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