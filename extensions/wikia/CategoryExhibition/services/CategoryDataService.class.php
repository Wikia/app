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
	
	public function getMostVisited( $sCategoryDBKey, $mNamespace, $limit = false, $negative = false  ){

		global $wgStatsDB, $wgCityId, $wgDevelEnvironment, $wgStatsDBEnabled;

		if ( empty( $wgStatsDBEnabled ) ) {
			Wikia::log(__METHOD__, ' Stats DB is disabled');
			return array();
		}

		if ( empty( $wgDevelEnvironment ) ) {
			// production mode
			
			if( !empty( $mNamespace ) ) {
				$tmp = array(
					'cl_to' => $sCategoryDBKey,
					'page_namespace ' . ($negative ? 'NOT ' : '') . 'IN(' . $mNamespace . ')'
				);
			} else {
				$tmp = array( 'cl_to' => $sCategoryDBKey );
			}

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'page', 'categorylinks' ),
				array( 'page_id', 'cl_to' ),
				$tmp,
				__METHOD__,
				array( 'ORDER BY' => 'page_title' ),
				array( 'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ) )
			);
			
			if ( $dbr->numRows( $res ) > 0 ) {
				Wikia::log(__METHOD__, ' Found some data in categories. Proceeding ');
				$aCategoryArticles = self::tableFromResult( $res );
				
				Wikia::log(__METHOD__, ' Searching for prepared data');

				$optionsArray = array();
				$optionsArray['ORDER BY'] = 'pv_views DESC';
				if ( !empty( $limit ) ) {
					$optionsArray['LIMIT'] = $limit;
				}
				
				if( !empty( $mNamespace )  ) {
					$tmp = array(
						'city_id' => $wgCityId,
						'page_ns ' . ($negative ? 'NOT ' : '') . 'IN(' . $mNamespace . ')'
					);
				} else {
					$tmp = array( 'city_id' => $wgCityId );
				}
				
				$dbr = wfGetDB( DB_SLAVE, null, $wgStatsDB );
				$res = $dbr->select(
					array( 'specials.page_views_summary_articles' ),
					array( 'page_id' ),
					$tmp,
					__METHOD__,
					$optionsArray
				);
				if ( ( $dbr->numRows( $res ) == 0 ) ) {
	
					Wikia::log(__METHOD__, ' No data. Try to gather some by myself');

					$optionsArray = array();
					$optionsArray['GROUP BY'] = 'pv_page_id';
					$optionsArray['ORDER BY'] = 'sum(pv_views) DESC';
					if ( !empty( $limit ) ) {
						$optionsArray['LIMIT'] = $limit;
					}

					if( !empty( $mNamespace )  ) {
						$tmp = array(
							'pv_city_id' => $wgCityId,
							'pv_namespace ' . ($negative ? 'NOT ' : '') . 'IN(' . $mNamespace . ')'
						);
					} else {
						$tmp = array( 'pv_city_id' => $wgCityId );
					}
					
					$lastMonth = strftime( "%Y%m%d", time() - 30 * 24 * 60 * 60 );
					$res = $dbr->select(
						array( 'page_views_articles' ),
						array( 'pv_page_id as page_id' ),
						$tmp,
						__METHOD__,
						$optionsArray
					);
				}
				if ( $dbr->numRows( $res ) > 0 ) {

					Wikia::log(__METHOD__, 'Found some data. Lets find a commmon part with categories');
					$aSortedArticles = self::tableFromResult( $res );
					$aResult = array();
					foreach( $aSortedArticles as $key => $val ){
						if ( isset($aCategoryArticles[$key]) ){
							unset( $aCategoryArticles[$key] );
							$aResult[$key] = $val;
							if ( !empty( $limit ) && count($aResult) >= $limit ){
								return $aResult;
							}
						}
					}

					return $aResult + $aCategoryArticles;
				} else {
					Wikia::log(__METHOD__, 'No data at all. Quitting.');
					return array();
				}
			} else {
				Wikia::log(__METHOD__, ' No articles in category found - quitting');
				return array();
			}
			
		} else {
			// devbox version

			$optionsArray = array();
			$optionsArray['ORDER BY'] = 'count DESC, page_title';
			if ( $limit ) {
				$optionsArray['LIMIT'] = $limit;
			}
			
			if( !empty( $mNamespace )  ) {
				$tmp = array(
					'cl_to' => $sCategoryDBKey,
					'page_namespace IN(' . $mNamespace . ')'
				);
			} else {
				$tmp = array( 'cl_to' => $sCategoryDBKey );
			}

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'page', 'page_visited', 'categorylinks' ),
				array( 'page_id', 'page_title' ),
				$tmp,
				__METHOD__,
				$optionsArray,
				array(	'page_visited'  => array( 'LEFT JOIN', 'article_id = page_id' ),
					'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ))
			);
			
			return self::tableFromResult( $res );
		}
	}
}
