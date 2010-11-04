<?php

/**
 * Main Category Gallery class
 */
class CategoryDataService extends Service {

	private static function tableFromResult( $res, $mNamespace = NS_MAIN ){

		$articles = array();
		while ($row = $res->fetchObject($res)) {
			$articles[intval($row->page_id)] = array(
				'page_id'		=> $row->page_id,
				'page_title'		=> $row->page_title,
				'page_namespace'	=> $mNamespace
			);
		}
		return $articles;
	}

	public static function getAlphabetical( $sCategoryDBKey, $mNamespace ){

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_id', 'page_title' ),
			array(
				'cl_to' => $sCategoryDBKey,
				'page_namespace IN(' . $mNamespace . ')'
			),
			__METHOD__,
			array(	'ORDER BY' => 'page_title' ),
			array(	'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ))
		);
		return self::tableFromResult( $res, $mNamespace );
	}

	public static function getRecentlyEdited( $sCategoryDBKey, $mNamespace ){
		
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'revision', 'categorylinks' ),
			array( 'page_id', 'page_title' ),
			array(
				'cl_to' => $sCategoryDBKey,
				'page_namespace IN(' . $mNamespace . ')'
			),
			__METHOD__,
			array(	'ORDER BY' => 'rev_timestamp DESC, page_title' ),
			array(	'revision'  => array( 'LEFT JOIN', 'rev_page = page_id' ),
				'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ))
		);
		return self::tableFromResult( $res, $mNamespace );
	}
	
	public function getMostVisited( $sCategoryDBKey, $mNamespace, $limit = false ){

		global $wgStatsDB, $wgCityId, $wgDevelEnvironment;

		$optionsArray = array();
		$optionsArray['ORDER BY'] = 'count DESC, page_title';
		if ( $limit ) {
			$optionsArray['LIMIT'] = $limit;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'page_visited', 'categorylinks' ),
			array( 'page_id', 'page_title' ),
			array(	'cl_to' => $sCategoryDBKey,
				'page_namespace IN(' . $mNamespace . ')'
			),
			__METHOD__,
			$optionsArray,
			array(	'page_visited'  => array( 'LEFT JOIN', 'article_id = page_id' ),
				'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ))
		);
		return self::tableFromResult( $res, $mNamespace );
	}
}