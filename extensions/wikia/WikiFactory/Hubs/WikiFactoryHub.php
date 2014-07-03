<?php

/**
 * @package MediaWiki
 * @subpackage WikiFactory
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia Inc.
 */

/**
 * Singleton class for handling Hubs
 */
class WikiFactoryHub extends WikiaModel {

	#--- static variables
	private static $mInstance = false;
	private static $mOldCategories = array();
	private static $mNewCategories = array();
	private static $cache_ttl = 86400;  // 1 day

	const CATEGORY_ID_HUMOR = 1;
	const CATEGORY_ID_GAMING = 2;
	const CATEGORY_ID_ENTERTAINMENT = 3;
	const CATEGORY_ID_CORPORATE = 4;
	const CATEGORY_ID_TOYS = 5;
	const CATEGORY_ID_FOODANDDRINK = 6;
	const CATEGORY_ID_TRAVEL = 7;
	const CATEGORY_ID_EDUCATION = 8;
	const CATEGORY_ID_LIFESTYLE = 9;
	const CATEGORY_ID_FINANCE = 10;
	const CATEGORY_ID_POLITICS = 11;
	const CATEGORY_ID_TECHNOLOGY = 12;
	const CATEGORY_ID_SCIENCE = 13;
	const CATEGORY_ID_PHILOSOPHY = 14;
	const CATEGORY_ID_SPORTS = 15;
	const CATEGORY_ID_MUSIC = 16;
	const CATEGORY_ID_CREATIVE = 17;
	const CATEGORY_ID_AUTO = 18;
	const CATEGORY_ID_GREEN = 19;
	const CATEGORY_ID_ANSWERS = 20;

	private static $mCategoryKruxMap = array(
	    self::CATEGORY_ID_HUMOR		=> 'Hixwr2ar',
	    self::CATEGORY_ID_GAMING		=> 'Hi0kJsuv',
	    self::CATEGORY_ID_ENTERTAINMENT	=> 'Hi0kPhMT',
	    self::CATEGORY_ID_CORPORATE		=> 'HixzfXzM',
	    self::CATEGORY_ID_TOYS		=> 'Hixy7C6A',
	    self::CATEGORY_ID_FOODANDDRINK	=> 'HixwQQcI',
	    self::CATEGORY_ID_TRAVEL		=> 'HixzKvV0',
	    self::CATEGORY_ID_EDUCATION		=> 'Hixv3Pm6',
	    self::CATEGORY_ID_LIFESTYLE		=> 'HixxTik3',
	    self::CATEGORY_ID_FINANCE		=> 'HixwC0-o',
	    self::CATEGORY_ID_POLITICS		=> 'Hixx8x9B',
	    self::CATEGORY_ID_TECHNOLOGY	=> 'HixyqEjH',
	    self::CATEGORY_ID_SCIENCE		=> 'HixyJ7zV',
	    self::CATEGORY_ID_PHILOSOPHY	=> 'HixxvJVY',
	    self::CATEGORY_ID_SPORTS		=> 'HixyZtmZ',
	    self::CATEGORY_ID_MUSIC		=> 'HixxfWsd',
	    self::CATEGORY_ID_CREATIVE		=> 'HixvqnFP',
	    self::CATEGORY_ID_AUTO		=> 'Hixvb8MR',
	    self::CATEGORY_ID_GREEN		=> 'Hixwf6fL',
	    self::CATEGORY_ID_ANSWERS		=> 'Hix9Xb-P'
	);

	/**
	 * private constructor
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 */
	public function __construct( ) {
		parent::__construct();

		// Load old and new categories (depends on app/db props from above)
		// This isn't really necessary for most use cases, refactor after transition
		// only getCategoryName and getCategoryShort and the UI/forms use $mOldCategories
		$this->loadCategories();
	}

	/**
	 * getInstance
	 *
	 * get singleton instance of class
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @return WikiFactoryHub object
	 */
	public static function getInstance() {
		if( self::$mInstance === false ) {
			self::$mInstance = new WikiFactoryHub();
		}
		return self::$mInstance;
	}

	/**
	 * return HTML select for category choosing
	 * FIXME: This uses the old categories and template system and will have to be updated
	 * FIXME: move this UI related code back into the wikifactory special page?
	 */
	public function getForm( $city_id, &$title = null ) {
		global $wgTitle;
		if( is_null( $title ) ) {
			$title = $wgTitle;
		}
		$cat_id = $this->getCategoryId( $city_id );
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title"			=> $title,
			"cat_id"		=> $cat_id,
			"city_id"	 	=> $city_id,
			"categories" 	=> self::$mOldCategories
		));

		return $oTmpl->render("categories");
	}

	/**
	 * return HTML select for category choosing
	 * FIXME: This uses the old categories and template system and will have to be updated
	 */
	public function getSelect( $cat_id ) {

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title"			=> null,
			"cat_id"		=> $cat_id,
			"categories" 	=> self::$mOldCategories
		));

		return $oTmpl->render("categories");
	}

	/**
	 * getCategories
	 *
	 * Get all categories and properties of those categories
	 *
	 * @access public
	 *
	 * @param $active boolean flag to return old or new categories, by default load the old ones while we are in transition phase
	 * @return array category names and ids from city_cats table
	 */
	public function getAllCategories( $new = false ) {

		if ( $new ) {
			return self::$mNewCategories;
		} else {
			// Deprecated/old categories
			return self::$mOldCategories;
		}
	}

	/**
	 * getAllVerticals
	 *
	 * Get all verticals and properties of those verticals
	 */

	public function getAllVerticals() {
		return array();

		$verticals = (new WikiaSQL())
			->SELECT()
				->FIELD( "vertical_id as id")
				->FIELD( "vertical_name as name")
				->FIELD( "vertical_url as url")
				->FIELD( "vertical_short as short")
			->FROM( "city_verticals" )
			->cache ( self::$cache_ttl )
			->runLoop( $this->getSharedDB(), function ( &$result, $row)  {
				$result[] = get_object_vars($row);
			});

		return $verticals;
	}

	/**
	 * getCategoryId
	 *
	 * get deprecated/old category id for given wiki
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param $city_id
	 * @return integer category id from city_cat_mapping table
	 *
	 * @deprecated Category is now an array, use getCategoryIds( $city_id )
	 */

	public function getCategoryId( $city_id ) {

		wfProfileIn( __METHOD__ );
		$categories = (new WikiaSQL())
			->SELECT( "cat_id" )
			->FROM( "city_cats" )
			->JOIN ( "city_cat_mapping" )->USING( "(cat_id)" )
			->WHERE( "city_id" )->EQUAL_TO( $city_id )
			->AND_( "cat_deprecated" )->EQUAL_TO ( 1 )  // always return the "old" category
			->cache( self::$cache_ttl )
			->runLoop ( $this->getSharedDB(), function ( &$result, $row ) {
				$result[]= $row->cat_id;
			});
		wfProfileOut( __METHOD__ );

		// Some wikis have no cat_mapping entry, but this should be fixed soon
		if (isset ($categories[0])) {
			return $categories[0];
		} else {
			return 0;
		}
	}

	/**
	 * getVerticalId
	 *
	 * Each wiki has one vertical
	 *
	 * @param  $city_id Wiki Id
	 * @return Integer vertical_id
	 */

	public function getVerticalId( $city_id ) {

		// TODO: create this table
		return 1;

		$memkey = sprintf("%s:%d", __METHOD__, $city_id);
		$id = (new WikiaSQL())
			->SELECT( "vertical_id" )
			->FROM( "city_verticals" )
			->WHERE ("city_id")->EQUAL_TO( $city_id )
			->cache( self::$cache_ttl, $memkey )
			->runLoop( $this->getSharedDB() );

		print_r($id);
		return $id;
	}

	/**
	 * getCategoryIds  This is the NEW function to use
	 *
	 * get list of (just) category ids for given wiki
	 *
	 * @access public
	 *
	 * @param $city_id
	 * @return array of categories (empty if wiki is not in a category)
	 *
	 */

	public function getCategoryIds( $city_id, $active = 1 ) {
		global $wgExternalSharedDB;
		if( !$wgExternalSharedDB ) {
			return array();
		}

		$categories = (new WikiaSQL())
			->SELECT( "cat_id" )
			->FROM( "city_cats" )
			->JOIN ( "city_cat_mapping" )->USING( "(cat_id)" )
			->WHERE( "city_id" )->EQUAL_TO( $city_id )
			->AND_( "cat_active" )->EQUAL_TO ( $active )
			->cache( self::$cache_ttl )
			->runLoop ( $this->getSharedDB(), function ( &$result, $row ) {
				$result[]= $row->cat_id;
			});

		return $categories;
	}

	/**
	 * Removed getCategories() function since it was ambiguous
	 * This function returns the list of categories AND category metadata for a wiki
	 * get category metadata (id, name, url, short, deprecated, active) for a wiki
	 * @param  integer $city_id  wiki_id
	 * @return array of keys/values (id, name, url, short, deprecated, active)
	 */
	public function getWikiCategories( $city_id, $active = 1 ) {

		// query instead of lookup in AllCategories list
		$categories = (new WikiaSQL())
			->SELECT( "*" )
			->FROM( "city_cats" )
			->JOIN ( "city_cat_mapping" )->USING( "(cat_id)" )
			->WHERE( "city_id ")->EQUAL_TO( $city_id )
			->AND_( "cat_active" )->EQUAL_TO ( $active )
			->cache ( self::$cache_ttl )
			->runLoop( $this->getSharedDB(), function ( &$result, $row)  {
				$result[] = get_object_vars($row);
			});

		return $categories;

	}

	/**
	 * get Full category name for a wiki
	 * This is deprecated, use getCategoriesForWiki instead
	 * @deprecated
	 */
	public function getCategoryName( $city_id ) {
		$cat_id = $this->getCategoryId( $city_id );
		return isset( self::$mOldCategories[ $cat_id ] )
			? self::$mOldCategories[ $cat_id ]["name"]
			: null;
	}

	/**
	 * get "short" category name for a wiki
	 * This is deprecated, use getCategoriesForWiki instead
	 * @param  [type] $city_id [description]
	 * @return [type]          [description]
	 * @deprecated
	 */
	public function getCategoryShort( $city_id ) {
		$cat_id = $this->getCategoryId( $city_id );
		return isset( self::$mOldCategories[ $cat_id ] )
			? self::$mOldCategories[ $cat_id ]["short"]
			: null;
	}
	/**
	 * loadCategories
	 *
	 * load all categories from city_cats table in wikicities database (WF)
	 *	 *
	 * @return array	array with category maps id => name, short
	 */
	private function loadCategoriesOld() {
		global $wgExternalSharedDB ;
		$tmp = array();
		if( !$wgExternalSharedDB ) {
			return array();
		}

		wfProfileIn( __METHOD__ );
		global $wgWikiFactoryCacheType;
		$oMemc = wfGetCache( $wgWikiFactoryCacheType );
		$memkey = sprintf("%s", __METHOD__);
		$cached = $oMemc->get($memkey);
		if ( empty($cached) ) {

			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			Wikia::log( __METHOD__, "var", $wgExternalSharedDB );
			$oRes = $dbr->select(
				array( "city_cats" ),
				array( "*" ),
				null,
				__METHOD__,
				array( "ORDER BY" => "cat_name" )
			);

			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$tmp[ $oRow->cat_id ] = array( "name" => $oRow->cat_name, "short" => $oRow->cat_short );
			}

			$dbr->freeResult( $oRes );
			$oMemc->set($memkey, $tmp, 60*60*24);
		} else {
			$tmp = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $tmp;
	}

	// LoadCategories
	// Loads ALL categories from city_cats table
	// Loads deprecated (old) categories into a separate array from active (new) categories

	private function loadCategories() {

		global $wgExternalSharedDB;
		if( !$wgExternalSharedDB ) {
			return array();
		}

		$categories = (new WikiaSQL())
			->SELECT()
				->FIELD( "cat_id as id")
				->FIELD( "cat_name as name")
				->FIELD( "cat_url as url")
				->FIELD( "cat_short as short")
				->FIELD( "cat_deprecated as deprecated")
				->FIELD( "cat_active as active")
			->FROM( "city_cats" )
			->cache ( self::$cache_ttl )  // global cache
			->runLoop( $this->getSharedDB(), function (&$result, $row) {
				$arr = get_object_vars($row);
				//$result['all'][] = $arr;
				if ($row->active) {
					$result['active'][$row->id] = $arr;
				}
				if ($row->deprecated) {
					$result['deprecated'][$row->id] = $arr;
				}
			} );

		self::$mOldCategories = $categories['deprecated'];
		self::$mNewCategories = $categories['active'];

	}

	/**
	 * setVertical
	 * update the vertical for the wiki
	 *
	 * @param integer   $city_id     identifier from city_list
	 * @param integer   $vertical_id vertical identifier
	 * @param string    $reason      optional extra reason string for logging
	 */

	// FIXME: purge the cache
	public function setVertical ( $city_id, $vertical_id, $reason) {

		( new WikiaSQL() )
			->UPDATE( 'city_list' )
				->SET( 'city_vertical', $vertical_id )
			->WHERE( 'city_id' )->EQUAL_TO( $city_id )
			->run( $this->getSharedDB() );

		if( !empty($reason) ) {
			$reason = " ( $reason )";
		}
		// I guess we should look up the name here
		WikiFactory::log( WikiFactory::LOG_CATEGORY, "Vertical changed to $vertical_id $reason", $city_id );

	}

	/**
	 * setCategory
	 *
	 * remove previous value in database and insert new one
	 *
	 * @param integer   $city_id    identifier from city_list
	 * @param integer   $cat_id     category identifier
	 * @param string    $reason     optional extra reason string for logging
	 *
	 * @deprecated This function is deprecated.  Now that there are multiple categories, we have to add/remove them with a new interface
	 */

	// FIXME: purge the category data from memcache when category is updated
	public function setCategory( $city_id, $cat_id, $reason='' ) {
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->begin();
		// first get old category
		$old_id = $this->getCategoryId($city_id);
		$dbw->delete( "city_cat_mapping", array( "city_id" => $city_id, "cat_id" => $old_id ), __METHOD__ );
		$dbw->insert( "city_cat_mapping", array( "city_id" => $city_id, "cat_id" => $cat_id ), __METHOD__  );

		// forces a refresh of new data
		$categories = $this->getCategories();
		if( !empty($reason) ) {
			$reason = " (" . (string)$reason . ")";
		}

		// ugly fast fix for fb#9937 (until all the hub management is cleaned up)
		global $wgMemc;
		$key = sprintf("%s:%d", 'WikiFactory::getCategory', intval($this->mWiki->city_id));
		$wgMemc->delete( $key );

		WikiFactory::log( WikiFactory::LOG_CATEGORY, "Category changed to {$categories[$cat_id]['name']}".$reason, $city_id );

		$dbw->commit();

		wfProfileOut( __METHOD__ );
	}

	/**
	 *
	 * @param integer $id category id
	 * @return category data
	 *
	 * Pretty sure this function is unused
	 */
	public function getCategory($id, $new = false) {
		if ($new) {
			return self::$mNewCategories[$id];
		} else {
			return self::$mOldCategories[$id];
		}
	}

	/**
	 * Get Krux id for given category
	 * @param int $categoryId
	 * @return string Krux category id
	 */
	public function getKruxId($categoryId) {
		if (isset(self::$mCategoryKruxMap[$categoryId])) {
			return self::$mCategoryKruxMap[$categoryId];
		}

		return '';
	}
}
