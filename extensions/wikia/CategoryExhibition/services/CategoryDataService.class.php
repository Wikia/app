<?php

/**
 * Main Category Gallery class
 */
class CategoryDataService extends Service {

	/**
	 * @param string $sCategoryDBKey
	 * @param string $mNamespace
	 * @param bool $negative
	 * @return array
	 */
	public static function getAlphabetical( $sCategoryDBKey, $mNamespace, $negative = false ) {
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_id', 'page_title' ),
			array(
				'cl_to' => $sCategoryDBKey,
				'page_namespace ' . ($negative ? 'NOT ' : '') . 'IN(' . $mNamespace . ')'
			),
			__METHOD__,
			array(	'ORDER BY' => 'page_title' ),
			array(	'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ))
		);

		$result = self::tableFromResult( $res );

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Return the number of articles that are in a particular category.
	 *
	 * @param string $sCategoryDBKey The DB key for the category
	 * @param string $mNamespace A namespace to filter on.  If not given, a count of articles in
	 *                        any namespace is returned
	 * @param bool $negative If $mNamespace is provided, this determines if this function returns
	 *                       a count of all articles with this category (false) or a count
	 *                       of all articles without this category (true).  Default is false.
	 * @return int The number of articles with this category
	 */
	public static function getArticleCount( $sCategoryDBKey, $mNamespace = '', $negative = false ) {
		wfProfileIn( __METHOD__ );

		if ( strlen($sCategoryDBKey) == 0 ) {
			wfProfileOut( __METHOD__ );
			return 0;
		}

		$db = wfGetDB( DB_SLAVE );

		$query = (new WikiaSQL())
			->SELECT()->COUNT('page_title')->AS_( 'count' )
			->FROM( 'page' )
				->JOIN( 'categorylinks' )->ON( 'cl_from', 'page_id' )
			->WHERE( 'cl_to' )->EQUAL_TO( $sCategoryDBKey );

		// If we have a namespace, convert it to an array
		if ( $mNamespace && !is_array($mNamespace) ) {
			$mNamespace = explode(',', $mNamespace);
		}

		// Decide whether we include or exclude the namespace passed to us.  If its null
		// don't include the namespace in the query at all
		if ( $mNamespace && $negative === true ) {
			$query->AND_( 'page_namespace' )->NOT_IN( $mNamespace );
		} else if ( $mNamespace && $negative === false ) {
			$query->AND_( 'page_namespace' )->IN( $mNamespace );
		}

		// Run the query we've built
		$count = $query->run( $db, function( ResultWrapper $result ) {
			$row = $result->fetchObject();
			return empty( $row ) ? 0 : $row->count;
		});

		wfProfileOut( __METHOD__ );

		// Make sure we default to zero
		return $count;
	}

	/**
	 * @param string $sCategoryDBKey
	 * @param array $mNamespace
	 * @param bool $limit
	 * @param bool $negative
	 * @return array
	 */
	public static function getMostVisited( $sCategoryDBKey, $mNamespace = null, $limit = false, $negative = false ) {
		global $wgCityId, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );

		if ( empty( $wgStatsDBEnabled ) ) {
			Wikia::log(__METHOD__, ' Stats DB is disabled');
			wfProfileOut( __METHOD__ );
			return array();
		}

		$where = array(
			'cl_to' => $sCategoryDBKey
		);

		if ( !empty( $mNamespace ) ) {
			$where[] = 'page_namespace ' . ($negative ? 'NOT ' : '') . 'IN(' . implode( ',', $mNamespace ) . ')';
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_id', 'cl_to' ),
			$where,
			__METHOD__,
			array( 'ORDER BY' => 'page_title' ),
			array( 'categorylinks' => array( 'INNER JOIN', 'cl_from = page_id' ) )
		);

		if ( $dbr->numRows( $res ) > 0 ) {
			Wikia::log(__METHOD__, ' Found some data in categories. Proceeding ');
			$aCategoryArticles = self::tableFromResult( $res );
			$catKeys = array_keys($aCategoryArticles);
			Wikia::log(__METHOD__, ' Searching for prepared data');

			//fix BugId:33086
			//use DataMart for pageviews data
			//as all the other data sources are disabled/obsolete
			$items = DataMartService::getTopArticlesByPageview( $wgCityId, $catKeys, $mNamespace , $negative, count( $catKeys ) );

			if ( is_array( $items ) && count( $items ) > 0 ) {
				Wikia::log(__METHOD__, ' Found some data. Lets find a commmon part with categories ');
				$aResult = array();
				$aResultCount = 0;
				$keys = array();
				$reversedCatKeys = array_flip($catKeys);

				$time = microtime(true);

				foreach ( $items as $id => $pv ) {
					$key = intval( $id );
					$keys[$key]= $key;
				}

				foreach ( $keys as $key ) {
					if ( isset( $reversedCatKeys[$key] ) ) {
						$aResultCount++;
						unset( $aCategoryArticles[$key] );
						$aResult[ $key ] = array( 'page_id' => $key );
						if ( !empty( $limit ) && $aResultCount >= $limit ) {
							self::logProcessingTime($time);

							wfProfileOut( __METHOD__ );
							return $aResult;
						}
					}
				}

				self::logProcessingTime($time);

				$ret = ( !empty( $aResult ) )  ? $aResult + $aCategoryArticles : $aCategoryArticles;

				if ( !empty( $limit ) && count( $ret ) > $limit ) {
					$ret = array_slice($ret, 0, $limit, true);
				}

				wfProfileOut( __METHOD__ );
				return $ret;
			} else {
				Wikia::log(__METHOD__, 'No data at all. Quitting.');
				wfProfileOut( __METHOD__ );
				return array();
			}
		} else {
			Wikia::log(__METHOD__, ' No articles in category found - quitting');
			wfProfileOut( __METHOD__ );
			return array();
		}
	}

	protected static function logProcessingTime( $time ) {
		Wikia::log(__METHOD__, ' Processing Time: ' . (microtime(true) - $time));
	}

	private static function tableFromResult( ResultWrapper $res ) {

		$articles = array();
		while ( $row = $res->fetchObject($res) ) {
			$articles[intval($row->page_id)] = array(
				'page_id' => $row->page_id
			);
		}

		return $articles;
	}
}
