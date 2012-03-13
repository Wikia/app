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

	public function getMostVisited( $sCategoryDBKey, $mNamespace = false, $limit = false, $negative = false ){

		global $wgStatsDB, $wgCityId, $wgStatsDBEnabled;

		if ( empty( $wgStatsDBEnabled ) ) {
			Wikia::log(__METHOD__, ' Stats DB is disabled');
			return array();
		}

		$where = array(
			'cl_to' => $sCategoryDBKey
		);

		if( !empty( $mNamespace ) ) {
			$where[] = 'page_namespace ' . ($negative ? 'NOT ' : '') . 'IN(' . $mNamespace . ')';
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

			//nice trick to get far less results from Stats DB in most cases
			$catKeys = array_keys($aCategoryArticles);
			$catKeyMin = min($catKeys);
			$catKeyMax = max($catKeys);

			Wikia::log(__METHOD__, ' Searching for prepared data');

			$optionsArray = array();
			$optionsArray['ORDER BY'] = 'pv_views DESC';

			$where = array(
				'city_id' => $wgCityId,
				'page_id > ' . $catKeyMin,
				'page_id < ' . $catKeyMax
			);

			if( !empty( $mNamespace )  ) {
				$where[] = 'page_ns ' . ($negative ? 'NOT ' : '') . 'IN(' . $mNamespace . ')';
			}

			$dbr = wfGetDB( DB_SLAVE, null, $wgStatsDB );
			$res = $dbr->select(
				array( 'specials.page_views_summary_articles' ),
				array( 'page_id' ),
				$where,
				__METHOD__,
				$optionsArray
			);

			if ( ( $dbr->numRows( $res ) == 0 ) ) {

				Wikia::log(__METHOD__, ' No data. Try to gather some by myself');

				$where = array(
					'pv_city_id' => $wgCityId,
					'pv_page_id > ' . $catKeyMin,
					'pv_page_id < ' . $catKeyMax
				);

				if( !empty( $mNamespace )  ) {
					$where[] = 'pv_namespace ' . ($negative ? 'NOT ' : '') . 'IN(' . $mNamespace . ')';
				}

				$res = $dbr->select(
					array( 'page_views_articles' ),
					array( 'pv_page_id as page_id' ),
					$where,
					__METHOD__,
					array(
						'GROUP BY' => 'pv_page_id',
						'ORDER BY' => 'sum(pv_views) DESC'
					)
				);
			}

			if ( $dbr->numRows( $res ) > 0 ) {

				Wikia::log(__METHOD__, 'Found some data. Lets find a commmon part with categories');

				$aResult = array();
				while ($row = $res->fetchObject($res)) {
					$key = $row->page_id;
					if ( in_array( $key, $catKeys ) ){
						unset( $aCategoryArticles[$key] );
						$aResult[ intval( $key ) ] = array( 'page_id' => $key );
						if ( !empty( $limit ) && count( $aResult ) >= $limit ){
							return $aResult;
						}
					}
				}

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
}
