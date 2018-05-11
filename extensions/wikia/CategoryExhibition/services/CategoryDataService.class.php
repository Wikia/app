<?php

/**
 * Main Category Gallery class
 */
class CategoryDataService {

	/**
	 * @param $sCategoryDBKey
	 * @param $mNamespace
	 * @param bool $negative
	 *
	 * @return TitleBatch
	 */
	public static function getAlphabetical( $sCategoryDBKey, array $mNamespace, $negative = false ): TitleBatch {
		$where = [ 'cl_to' => $sCategoryDBKey ];

		if ( !empty( $mNamespace ) ) {
			$where[] = 'page_namespace ' . ( $negative ? 'NOT ' : '' ) . 'IN(' . implode( ',', $mNamespace ) . ')';
		}

		return TitleBatch::newFromConds(
			'categorylinks',
			$where,
			__METHOD__,
			[ 'ORDER BY' => 'page_title' ],
			[ 'categorylinks' => [ 'INNER JOIN', 'cl_from = page_id' ] ]
		);
	}

	/**
	 * Return the number of articles that are in a particular category.
	 *
	 * TODO: use Mostpopularcategories query cache
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

		if ( strlen($sCategoryDBKey) == 0 ) {
			return 0;
		}

		// cache the counter for 24h (the same policy is applied for Mostpopularcategories query cache)
		return WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, $sCategoryDBKey, $mNamespace, $negative ? 1 : 0 ),
			WikiaResponse::CACHE_STANDARD,
			function() use ( $sCategoryDBKey, $mNamespace, $negative ) {
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

				return $count;
			}
		);
	}

	/**
	 * @param string $sCategoryDBKey
	 * @param array $mNamespace
	 * @param bool $limit
	 * @param bool $negative
	 * @return array
	 */
	public static function getMostVisited( $sCategoryDBKey, $mNamespace = [], $limit = false, $negative = false ) {
		global $wgCityId, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );

		if ( empty( $wgStatsDBEnabled ) ) {
			Wikia::log(__METHOD__, ' Stats DB is disabled');
			wfProfileOut( __METHOD__ );
			return array();
		}

		$categoryMembersTitles = self::getAlphabetical( $sCategoryDBKey, $mNamespace, $negative )->getAll();
		if ( count( $categoryMembersTitles ) > 0 ) {
			Wikia::log(__METHOD__, ' Found some data in categories. Proceeding ');
			$categoryMembersIds = array_keys( $categoryMembersTitles );
			Wikia::log(__METHOD__, ' Searching for prepared data');

			//fix BugId:33086
			//use DataMart for pageviews data
			//as all the other data sources are disabled/obsolete
			$topViewedCategoryMembersById = DataMartService::getTopArticlesByPageview( $wgCityId, $categoryMembersIds, $mNamespace , $negative, count( $categoryMembersIds ) );

			if ( is_array( $topViewedCategoryMembersById ) && count( $topViewedCategoryMembersById ) > 0 ) {
				Wikia::log(__METHOD__, ' Found some data. Lets find a commmon part with categories ');
				$mostViewedArticlesFromCategory = [];
				$aResultCount = 0;

				$time = microtime(true);

				foreach ( $topViewedCategoryMembersById as $id => $data) {
					$id = intval( $id );
					if ( isset( $categoryMembersTitles[$id] ) ) {
						$mostViewedArticlesFromCategory[ $id ] = $categoryMembersTitles[$id];
						$aResultCount++;
						unset( $categoryMembersTitles[$id] );
						if ( !empty( $limit ) && $aResultCount >= $limit ) {
							self::logProcessingTime($time);

							wfProfileOut( __METHOD__ );
							return $mostViewedArticlesFromCategory;
						}
					}
				}

				self::logProcessingTime($time);

				$ret = ( !empty( $mostViewedArticlesFromCategory ) )  ? $mostViewedArticlesFromCategory + $categoryMembersTitles : $categoryMembersTitles;

				if ( !empty( $limit ) && count( $ret ) > $limit ) {
					$ret = array_slice($ret, 0, $limit, true);
				}

				wfProfileOut( __METHOD__ );
				return $ret;
			} else {
				Wikia::log(__METHOD__, 'No data at all. Quitting.');
				wfProfileOut( __METHOD__ );
				return [];
			}
		} else {
			Wikia::log(__METHOD__, ' No articles in category found - quitting');
			wfProfileOut( __METHOD__ );
			return [];
		}
	}

	protected static function logProcessingTime( $time ) {
		Wikia::log(__METHOD__, ' Processing Time: ' . (microtime(true) - $time));
	}
}
