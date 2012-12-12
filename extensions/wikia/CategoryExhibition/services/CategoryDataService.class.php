<?php

/**
 * Main Category Gallery class
 */
class CategoryDataService extends Service {

	private static function tableFromResult( $res ){

		$articles = array();
		while ($row = $res->fetchObject($res)) {
			$articles[intval($row->page_id)] = array(
				'page_id'		=> $row->page_id
			);
		}

		return $articles;
	}

	public static function getAlphabetical( $sCategoryDBKey, $mNamespace, $negative = false ){

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
		return self::tableFromResult( $res );
	}

	public static function getRecentlyEdited( $sCategoryDBKey, $mNamespace, $negative = false  ){

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'revision', 'categorylinks' ),
			array( 'page_id', 'page_title' ),
			array(
				'cl_to' => $sCategoryDBKey,
				'page_namespace ' . ($negative ? 'NOT ' : '') . 'IN(' . $mNamespace . ')'
			),
			__METHOD__,
			array(	'ORDER BY' => 'rev_timestamp DESC, page_title' ),
			array(	'revision'  => array( 'LEFT JOIN', 'rev_page = page_id' ),
				'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ))
		);
		return self::tableFromResult( $res );
	}

	public static function getMostVisited( $sCategoryDBKey, $mNamespace = null, $limit = false, $negative = false ){
		global $wgStatsDB, $wgCityId, $wgStatsDBEnabled;

		if ( empty( $wgStatsDBEnabled ) ) {
			Wikia::log(__METHOD__, ' Stats DB is disabled');
			return array();
		}

		$where = array(
			'cl_to' => $sCategoryDBKey
		);

		if( !empty( $mNamespace ) ) {
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

				foreach($keys as $key) {
					if ( isset( $reversedCatKeys[$key] ) ){
						$aResultCount++;
						unset( $aCategoryArticles[$key] );
						$aResult[ $key ] = array( 'page_id' => $key );
						if ( !empty( $limit ) && $aResultCount >= $limit ){
							self::logProcessingTime($time);
							return $aResult;
						}
					}
				}

				self::logProcessingTime($time);

				$ret = ( !empty( $aResult ) )  ? $aResult + $aCategoryArticles : $aCategoryArticles;

				if( !empty( $limit ) && count( $ret ) > $limit ) {
					$ret = array_slice($ret, 0, $limit, true);
				}

				return $ret;
			} else {
				Wikia::log(__METHOD__, 'No data at all. Quitting.');
				return array();
			}
		} else {
			Wikia::log(__METHOD__, ' No articles in category found - quitting');
			return array();
		}
	}

	protected static function logProcessingTime($time) {
		Wikia::log(__METHOD__, ' Processing Time: ' . (microtime(true) - $time));
	}
}
