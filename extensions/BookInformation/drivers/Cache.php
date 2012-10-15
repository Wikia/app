<?php
/**
 * Cache for book information requests
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

class BookInformationCache {
	/**
	 * Retrieve the result associated with an ISBN from
	 * the cache, if available
	 *
	 * @param string $isbn ISBN being queried
	 * @return mixed BookInformationResult or false on cache miss
	 */
	public static function get( $isbn ) {
		global $wgBookInformationCache;
		if ( $wgBookInformationCache ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->selectRow( 'bookinfo', '*', array( 'bi_isbn' => $isbn ), __METHOD__ );
			if ( $res ) {
				$result = unserialize( $dbr->decodeBlob( $res->bi_result ) );
				if ( is_object( $result ) && $result instanceof BookInformationResult ) {
					wfDebugLog( 'bookinfo', "Cache hit for {$isbn}\n" );
					return $result;
				} else {
					wfDebugLog( 'bookinfo', "Cache received unexpected class from database for {$isbn}\n" );
					return false;
				}
			} else {
				wfDebugLog( 'bookinfo', "Cache miss for {$isbn}\n" );
				return false;
			}
		} else {
			wfDebugLog( 'bookinfo', "Cache disabled; implicit miss for {$isbn}\n" );
			return false;
		}
	}

	public static function set( $isbn, $result ) {
		global $wgBookInformationCache;
		if ( $wgBookInformationCache ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->insert( 'bookinfo', self::prepareValues( $isbn, $result, $dbw ), __METHOD__, 'IGNORE' );
		}
	}

	private static function prepareValues( $isbn, $result, $dbw ) {
		return array(
			'bi_isbn' => $isbn,
			'bi_result' => $dbw->encodeBlob( serialize( $result ) ),
		);
	}
}
