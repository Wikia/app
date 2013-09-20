<?php

/**
 * Class provides an easy interface to preload requested data
 * in the given collection of Title objects
 * doing it in a batch in a single db query
 *
 * @author Władysław Bodzek
 */
class TitleBatch {

	protected $titles = array();
	protected $articleIds = false;
	protected $restrictionsLoaded = false;

	/**
	 * Creates a new TitleBatch object
	 *
	 * @param $titles array List of Title objects or title texts
	 */
	public function __construct( $titles ) {
		foreach ($titles as $k => $title) {
			if ( $title instanceof Title ) {
				// nothing to do...
			} elseif ( is_string($title) ) {
				$titles[$k] = Title::newFromText($title);
			} else {
				wfDebug( "Warning: TitleBatch::__construct got invalid title object/text\n" );
			}
		}
		$this->titles = $titles;
	}

	/**
	 * Get a list of article ids for titles that exist
	 *
	 * @return array List of article ids
	 */
	protected function getArticleIds() {
		wfProfileIn( __METHOD__ );
		if ( $this->articleIds === false ) {
			wfProfileIn( __METHOD__ . '::CacheMiss' );
			$ids = array();
			foreach ($this->titles as $title) {
				$id = $title->getArticleID();
				if ( $id > 0 ) {
					$ids[] = $id;
				}
			}
			$this->articleIds = $ids;
			wfProfileOut( __METHOD__ . '::CacheMiss' );
		}
		wfProfileOut( __METHOD__ );

		return $this->articleIds;
	}

	/**
	 * Prefetch information about page restrictions and feed
	 * that into the Title objects
	 *
	 * @return TitleBatch Provides fluent interface
	 */
	public function loadRestrictions() {
		wfProfileIn( __METHOD__ );
		if ( !$this->restrictionsLoaded ) {
			wfProfileIn( __METHOD__ . '::CacheMiss' );
			$articleIds = $this->getArticleIds();
			if ( empty( $articleIds ) ) {
				wfProfileOut( __METHOD__ . '::CacheMiss' );
				wfProfileOut( __METHOD__ );
				return $this;
			}

			$dbr = wfGetDB( DB_SLAVE );

			// load rows from page_restrictions
			$res = $dbr->select(
				'page_restrictions',
				'*',
				array( 'pr_page' => $articleIds ),
				__METHOD__
			);
			$byArticle = array();
			foreach ($res as $row) {
				$id = $row->pr_page;
				if ( !isset($byArticle[$id]) ) {
					$byArticle[$id] = array();
				}
				$byArticle[$id][] = $row;
			}
			$res->free();

			// load rows from page.page_restriction
			$res = $dbr->select(
				'page',
				array( 'page_id', 'page_restrictions' ),
				array( 'page_id' => $articleIds ),
				__METHOD__
			);
			$oldFashioned = array();
			foreach ($res as $row) {
				$oldFashioned[$row->page_id] = (string)$row->page_restrictions;
			}
			$res->free();

			// feed fetched data to Title objects
			foreach ($this->titles as $title) {
				$id = $title->getArticleID();
				$restrictions = isset($byArticle[$id]) ? $byArticle[$id] : array();
				$old = isset($oldFashioned[$id]) ? $oldFashioned[$id] : '';
				$title->loadRestrictionsFromRows($restrictions,$old);
			}
			wfProfileOut( __METHOD__ . '::CacheMiss' );
		}
		wfProfileOut( __METHOD__ );

		return $this;
	}

	/**
	 * Get the collection of Title objects
	 *
	 * @return array List of Title objects
	 */
	public function getAll() {
		return $this->titles;
	}

	/**
	 * Get wikia-properties requested by its ID
	 *
	 * @param $propertyIds One or many property IDs to fetch
	 * @param $dbType int Database connection type
	 * @return array 1-D or 2-D array representing fetched properties (2-D if more than one property ID was provided)
	 */
	public function getWikiaProperties( $propertyIds, $dbType = DB_SLAVE ) {
		$articleIds = $this->getArticleIds();
		$res = wfGetDB($dbType)->select(
			array( 'p' => 'page', 'pp' => 'page_wikia_props' ),
			array( 'p.page_id, pp.propname, pp.props' ),
			array(
				'p.page_id = pp.page_id',
				'pp.propname' => $propertyIds,
			),
			__METHOD__
		);

		$props = array();
		foreach ($res as $row) {
			if ( is_array( $propertyIds ) ) {
				$props[$row->page_id][$row->propname] = wfUnserializeProp($row->propname, $row->props);
			} else {
				$props[$row->page_id] = wfUnserializeProp($row->propname, $row->props);
			}
		}
		return $props;
	}

	/**
	 * Get Title objects for a given set of article IDs. Skips articles that do not exist.
	 *
	 * @param $ids array List of article IDs
	 * @param $dbType int Database connection type (supports DB_SLAVE_BEFORE_MASTER)
	 * @return array Array with article IDs as keys and Title objects as values (non-existent articles ore omitted)
	 */
	static public function newFromIds( $ids, $dbType ) {
		wfProfileIn( __METHOD__ );

		if ( empty($ids) ) {
			wfProfileOut( __METHOD__ );
			return array();
		}

		$list = array();

		$db = wfGetDB( $dbType == DB_SLAVE_BEFORE_MASTER ? DB_SLAVE : $dbType );
		$res = $db->select( 'page', '*', array( 'page_id' => $ids ), __METHOD__ );
		foreach ($res as $row) {
			$list[$row->page_id] = Title::newFromRow($row);
		}
		$res->free();

		if ( $dbType == DB_SLAVE_BEFORE_MASTER && count($list) < count($ids) ) {
			$remainingIds = array_diff( $ids, array_keys($list) );
			$db = wfGetDB( DB_MASTER );
			$res = $db->select( 'page', '*', array( 'page_id' => $remainingIds ), __METHOD__ );
			foreach ($res as $row) {
				$list[$row->page_id] = Title::newFromRow($row);
			}
			$res->free();
		}

		wfProfileOut( __METHOD__ );
		return $list;
	}

	/**
	 * Get Title objects for all articles that satisfy provided SQL SELECT conditions
	 *
	 * @param $tables array|string Additional tables
	 * @param $conds array|string Conditions
	 * @param $fname string Function name
	 * @param $options array Query options
	 * @param $dbType int Database connection type (doesn't support DB_SLAVE_BEFORE_MASTER)
	 * @return array Array with article IDs as keys and Title objects as values (non-existent articles ore omitted)
	 */
	static public function newFromConds( $tables, $conds, $fname = 'TitleBatch::newFromConds',
			$options = array(), $dbType = DB_SLAVE ) {
		wfProfileIn( __METHOD__ );

		$tables = array_merge( array( 'page' ), (array)$tables );

		$list = array();

		$db = wfGetDB( $dbType );
		$res = $db->select( $tables, 'page.*', $conds, $fname, $options );
		foreach ($res as $row) {
			$list[$row->page_id] = Title::newFromRow($row);
		}
		$res->free();

		wfProfileOut( __METHOD__ );
		return $list;
	}


}
