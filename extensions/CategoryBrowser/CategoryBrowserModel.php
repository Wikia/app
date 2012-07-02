<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of CategoryBrowser.
 *
 * CategoryBrowser is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * CategoryBrowser is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CategoryBrowser; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * CategoryBrowser is an AJAX-enabled category filter and browser for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named CategoryBrowser into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/CategoryBrowser/CategoryBrowser.php";
 *
 * @version 0.3.1
 * @link http://www.mediawiki.org/wiki/Extension:CategoryBrowser
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

abstract class CB_AbstractPager {

	var $db;
	var $page_table;
	var $category_table;
	var $categorylinks_table;
	// select pages number without number of categories or files
	static $cat_pages_only = '(cat_pages - cat_subcats - cat_files) as cat_pages_only';

	/* pager position (actual offset)
	 * 0 means pager has no previous elements
	 * -1 means pager has no elements at all
	 */
	var $offset = -1;
	/* provided "source" offset */
	var $query_offset;
	/* indicates, whether the pager has further elements */
	var $hasMoreEntries = false;
	/**
	 * maximal number of entries per page (actual number of entries on page)
	 * warning: is not initialized until $this->getCurrentRows() call
	 */
	var $limit = 0;
	/* provided "source" limit */
	var $query_limit;
	/* array of current entries */
	var $entries = array();

	/**
	 * abstract query (doesn't instantinate)
	 * @param offset - suggested SQL offset
	 * @param limit - suggested SQL limit
	 */
	function __construct( $offset, $limit ) {
		$this->db = & wfGetDB( DB_SLAVE );
		$this->page_table = $this->db->tableName( 'page' );
		$this->category_table = $this->db->tableName( 'category' );
		$this->categorylinks_table = $this->db->tableName( 'categorylinks' );
		$this->query_limit = intval( $limit );
		$this->query_offset = intval( $offset );
	}

	/**
	 *
	 * initializes hasMoreEntries and array of entries from DB result
	 */
	function setEntries( &$db_result ) {
		$this->hasMoreEntries = false;
		$this->entries = array();
		$count = $this->db->numRows( $db_result );
		if ( $count < 1 ) { return; }
		$this->offset = $this->query_offset;
		$this->limit = $this->query_limit;
		if ( $this->hasMoreEntries = $count > $this->limit ) {
			// do not include "overflow" entry, it belongs to the next page
			$count--;
		}
		// do not include last row (which was loaded only to set hasMoreEntries)
		for ( $i = 0; $i < $count; $i++ ) {
			$row = $this->db->fetchObject( $db_result );
			$this->entries[] = $row;
		}
	}

	// returns previous SQL select offset
	function getPrevOffset() {
		$prev_offset = $this->offset - $this->limit;
		return ( ( $prev_offset >= 0 ) ? $prev_offset : 0 );
	}

	// returns next SQL select offset
	function getNextOffset() {
		return ( ( $this->hasMoreEntries ) ? $this->offset + $this->limit : 0 );
	}

} /* end of CB_AbstractPager class */

/**
 * parent categories pager
 */
class CB_ParentPager extends CB_AbstractPager {

	// database cat_title of children category (with underscores, dbkey-like)
	var $childCatName;

	function __construct( $childCatName, $offset, $limit ) {
		parent::__construct( $offset, $limit );
		$this->childCatName = $childCatName;
	}

	/**
	 * set offset, limit, hasMoreEntries and entries
	 * @param $offset SQL offset
	 * @param $limit SQL limit
	 */
	function getCurrentRows() {
		if ( !CB_Setup::$allowNestedParents ) {
			return;
		}
		/*
			SELECT null cl_sortkey,cat_id,cat_title,cat_subcats,cat_pages,cat_files FROM `wiki_page` INNER JOIN `wiki_categorylinks` ON (cl_from = page_id AND page_namespace=14 AND page_title='Жизненные_ценности' ) INNER JOIN `wiki_category` ON (cat_title = cl_to) ORDER BY cat_title
		*/
		$query_string =
			"SELECT null cl_sortkey,cat_id,cat_title,cat_subcats," . self::$cat_pages_only . ",cat_files " .
			"FROM {$this->page_table} " .
			"INNER JOIN {$this->categorylinks_table} ON (cl_from = page_id AND page_namespace=14 AND page_title=" . $this->db->addQuotes( $this->childCatName ) . ") " .
			"INNER JOIN {$this->category_table} ON (cat_title = cl_to) " .
			"ORDER BY cat_title ";
		$res = $this->db->query( $query_string . "LIMIT {$this->query_offset}," . ( $this->query_limit + 1 ), __METHOD__ );
		$this->setEntries( $res );
	}

	/**
	 * returns JS function call used to navigate to the previous page of this pager
	 * when placeholders = true, empty html placeholder should be generated in pager view instead of link
	 * when placeholders = false, nothing ('') will be generated in pager view instead of link
	 */
	function getPrevAjaxLink() {
		$result = (object) array(
			"call" => "return CategoryBrowser.parentCatsNav(this,'" . Xml::escapeJsString( $this->childCatName ) . "'," . $this->getPrevOffset() . ( ( $this->limit == CB_PAGING_ROWS ) ? '' : ',' . $this->limit ) . ')',
			"placeholders" => false
		);
		return $result;
	}

	/**
	 * returns JS function call used to navigate to the next page of this pager
	 * when placeholders = true, empty html placeholder should be generated in pager view instead of link
	 * when placeholders = false, nothing ('') will be generated in pager view instead of link
	 */
	function getNextAjaxLink() {
		$result = (object) array(
			"call" => "return CategoryBrowser.parentCatsNav(this,'" . Xml::escapeJsString( $this->childCatName ) . "'," . $this->getNextOffset() . ( ( $this->limit == CB_PAGING_ROWS ) ? '' : ',' . $this->limit ) . ')',
			"placeholders" => false
		);
		return $result;
	}

} /* end of CB_ParentPager class */

/**
 * subentries (subcategories, pages, files) pager
 * TODO: gracefully set offset = 0 when too large offset was given
 */
class CB_SubPager extends CB_AbstractPager {

	// database cat_title of parent category (with underscores, dbkey-like)
	var $parentCatName;
	// database fields to query
	var $select_fields;
	// namespace SQL condition (WHERE part)
	var $ns_cond;
	// javascript function used to navigate between the pages
	var $js_nav_func;

	/**
	 * creates subcategory list pager
	 *
	 * @param $parentCatName cat_title of parent category
	 * @param $offset SQL offset
	 * @param $limit SQL limit
	 *
	 * TODO: query count of parent subcategories/pages/files in category table for progress / percentage display
	 */
	function __construct( $parentCatName, $offset, $limit, $js_nav_func, $select_fields = '*', $ns_cond = '' ) {
		parent::__construct( $offset, $limit );
		$this->parentCatName = $parentCatName;
		$this->select_fields = $select_fields;
		$this->ns_cond = $ns_cond;
		$this->js_nav_func = $js_nav_func;
	}

	/**
	 * set offset, limit, hasMoreEntries and entries
	 * @param $offset SQL offset
	 * @param $limit SQL limit
	 */
	function getCurrentRows() {
		/*
		 * SELECT cl_sortkey,cat_id,cat_title,cat_subcats,cat_pages,cat_files FROM `wiki_page` INNER JOIN `wiki_categorylinks` FORCE INDEX (cl_sortkey) ON (cl_from = page_id) LEFT JOIN `wiki_category` ON (cat_title = page_title AND page_namespace = 14)  WHERE cl_to = 'parent category name' AND page_namespace = 14 ORDER BY cl_sortkey LIMIT 0,11
		 */
		$query_string =
			"SELECT {$this->select_fields} " .
			"FROM {$this->page_table} " .
			"INNER JOIN {$this->categorylinks_table} FORCE INDEX (cl_sortkey) ON (cl_from = page_id) " .
			"LEFT JOIN {$this->category_table} ON (cat_title = page_title AND page_namespace = " . NS_CATEGORY . ") " .
			"WHERE cl_to = " . $this->db->addQuotes( $this->parentCatName ) .
			( ( $this->ns_cond == '' ) ? ' ' : "AND {$this->ns_cond} " ) .
			"ORDER BY cl_sortkey ";
		$res = $this->db->query( $query_string . "LIMIT {$this->query_offset}," . ( $this->query_limit + 1 ), __METHOD__ );
		$this->setEntries( $res );
	}

	/**
	 * returns JS function call used to navigate to the previous page of this pager
	 * when placeholders = true, empty html placeholder should be generated in pager view instead of link
	 * when placeholders = false, nothing ('') will be generated in pager view instead of link
	 */
	function getPrevAjaxLink() {
		$result = (object) array(
			"call" => "return CategoryBrowser.{$this->js_nav_func}(this,'" . Xml::escapeJsString( $this->parentCatName ) . "'," . $this->getPrevOffset() . ( ( $this->limit == CB_PAGING_ROWS ) ? '' : ',' . $this->limit ) . ')',
			"placeholders" => false
		);
		return $result;
	}

	/**
	 * returns JS function call used to navigate to the next page of this pager
	 * when placeholders = true, empty html placeholder should be generated in pager view instead of link
	 * when placeholders = false, nothing ('') will be generated in pager view instead of link
	 */
	function getNextAjaxLink() {
		$result = (object) array(
			"call" => "return CategoryBrowser.{$this->js_nav_func}(this,'" . Xml::escapeJsString( $this->parentCatName ) . "'," . $this->getNextOffset() . ( ( $this->limit == CB_PAGING_ROWS ) ? '' : ',' . $this->limit ) . ')',
			"placeholders" => false
		);
		return $result;
	}

}  /* end of CB_SubPager class */

/**
 * creates a root category pager
 * TODO: gracefully set offset = 0 when too large offset was given
 * TODO: with $conds == '' categories aren't always sorted alphabetically
 */
class CB_RootPager extends CB_AbstractPager {


	/* string paging conds aka filter (WHERE statement) */
	var $conds;
	/* _optional_ instance of CB_SqlCond object used to construct this pager
	 * (in case it's been provided in constructor call)
	 */
	var $sqlCond = null;

	// by default, query for all categories, not just these which have no parents
	var $noParentsOnly = false;

	// category name filter (LIKE)
	var $nameFilter = '';
	// category name filter case-insensetive flag (when true, tries to use insensetive LIKE COLLATE)
	var $nameFilterCI = false;

	/**
	 * formal constructor
	 * real instantination should be performed by calling public static methods below
	 */
	function __construct( $offset, $limit ) {
		parent::__construct( $offset, $limit );
	}

	/**
	 * @param $conds - instanceof CB_SqlCond (parentized condition generator)
	 * @param $offset - SQL OFFSET
	 * @param $limit - SQL LIMIT
	 */
	public static function newFromSqlCond( CB_SqlCond $conds, $offset = 0, $limit = CB_PAGING_ROWS ) {
		$rp = new CB_RootPager( $offset, $limit );
		$rp->conds = $conds->getCond();
		$rp->sqlCond = &$conds;
		return $rp;
	}

	/**
	 * @param $tokens - array of infix ops of sql condition
	 * @param $offset - SQL OFFSET
	 * @param $limit - SQL LIMIT
	 */
	public static function newFromInfixTokens( $tokens, $offset = 0, $limit = CB_PAGING_ROWS ) {
		if ( !is_array( $tokens ) ) {
			return null;
		}
		try {
			$sqlCond = CB_SqlCond::newFromInfixTokens( $tokens );
		} catch ( MWException $ex ) {
			return null;
		}
		return self::newFromSqlCond( $sqlCond, $offset, $limit );
	}

	/**
	 * create root pager from the largest non-empty category range
	 * @param $ranges - array of "complete" token queues (range)
	 *   (every range is an stdobject of decoded infix queue and encoded reverse polish queue)
	 */
	public static function newFromCategoryRange( $ranges ) {
		$rp = null;
		foreach ( $ranges as &$range ) {
			$rp = CB_RootPager::newFromInfixTokens( $range->infix_tokens );
			$rp->getCurrentRows();
			if ( is_object( $rp ) && $rp->offset != -1 ) {
				break;
			}
		}
		return $rp;
	}

	/**
	 * setup query only for categories, which does not have the parents
	 * @param: $noParentsOnly - boolean flag
	 *     true - query only for categories, which does not have the parents
	 */
	function setNoParentsOnly( $noParentsOnly ) {
		$this->noParentsOnly = (boolean) $noParentsOnly;
	}

	/**
	 * filter catetories by names
	 * @param $cat_name_filter - string category name begins from
	 * @param $cat_name_filter_ci - boolean, true attempts to use case-insensetive search, when available
	 */
	function setNameFilter( $cat_name_filter, $cat_name_filter_ci ) {
		$this->nameFilter = str_replace( ' ', '_', ltrim( $cat_name_filter ) );
		$this->nameFilterCI = $cat_name_filter_ci;
	}

	/**
	 * performs range query and stores the results
	 */
	function getCurrentRows() {
		$conds = trim( $this->conds );
		// use name filter, when available
		if ( $this->nameFilter != '' ) {
			if ( $conds != '' ) {
				$conds = "( $conds ) AND ";
			}
			$conds .= 'cat_title LIKE ' . $this->db->addQuotes( $this->nameFilter . '%' );
			if ( $this->nameFilterCI && CB_Setup::$cat_title_CI != '' ) {
				// case insensetive search is active
				$conds .= ' COLLATE ' . $this->db->addQuotes( CB_Setup::$cat_title_CI );
			}
		}
		if ( CB_Setup::$allowNoParentsOnly && $this->noParentsOnly ) {
			/*
				SELECT * FROM `wiki_category` INNER JOIN `wiki_categorylinks` AS childs ON (cat_title = cl_to) LEFT JOIN `wiki_page` ON ( childs.cl_to = page_title AND page_namespace = 14 ) LEFT JOIN `wiki_categorylinks` AS parents ON ( page_id = parents.cl_from ) WHERE parents.cl_from IS NULL GROUP BY childs.cl_to ORDER BY childs.cl_to
			*/
			$conds = "parents.cl_from IS NULL" . ( ($conds == '') ? '' : " AND ${conds}" );
			$query_string =
				"SELECT cat_id, cat_title, " . self::$cat_pages_only . ", cat_subcats, cat_files FROM {$this->category_table} " .
				"INNER JOIN {$this->categorylinks_table} AS childs ON (cat_title = cl_to) " .
				"LEFT JOIN {$this->page_table} ON (childs.cl_to = page_title AND page_namespace = 14) " .
				"LEFT JOIN {$this->categorylinks_table} AS parents ON (page_id = parents.cl_from) " .
				"WHERE ${conds} GROUP BY childs.cl_to ORDER BY childs.cl_to ";
			$res = $this->db->query( $query_string . "LIMIT {$this->query_offset}," . ( $this->query_limit + 1 ), __METHOD__ );
		} else {
			$res = $this->db->select( 'category',
				array( 'cat_id', 'cat_title', self::$cat_pages_only, 'cat_subcats', 'cat_files' ),
				$conds,
				__METHOD__,
				array( 'OFFSET' => $this->query_offset, 'ORDER BY' => 'cat_title', 'LIMIT' => $this->query_limit + 1 )
			);
		}
		/* set actual offset, limit, hasMoreEntries and entries */
		$this->setEntries( $res );
	}

	/**
	 * returns JS function call used to navigate to the previous page of this pager
	 * when placeholders = true, empty html placeholder should be generated in pager view instead of link
	 * when placeholders = false, nothing ('') will be generated in pager view instead of link
	 */
	function getPrevAjaxLink() {
		$result = (object) array(
			"call" => 'return CategoryBrowser.rootCats(\'' . Xml::escapeJsString( $this->sqlCond->getEncodedQueue( false ) ) . '\',' . $this->getPrevOffset() . ( ( $this->limit == CB_PAGING_ROWS ) ? '' : ',' . $this->limit ) . ')',
			"placeholders" => true
		);
		return $result;
	}

	/**
	 * returns JS function call used to navigate to the next page of this pager
	 * when placeholders = true, empty html placeholder should be generated in pager view instead of link
	 * when placeholders = false, nothing ('') will be generated in pager view instead of link
	 */
	function getNextAjaxLink() {
		$result = (object) array(
			"call" => 'return CategoryBrowser.rootCats(\'' . Xml::escapeJsString( $this->sqlCond->getEncodedQueue( false ) ) . '\',' . $this->getNextOffset() . ( ( $this->limit == CB_PAGING_ROWS ) ? '' : ',' . $this->limit ) . ')',
			"placeholders" => false
		);
		return $result;
	}

} /* end of CB_RootPager class */
