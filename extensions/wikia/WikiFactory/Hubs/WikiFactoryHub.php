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
	private $mOldCategories = array();
	private $mNewCategories = array();
	private $mAllCategories = array();
	private $cache_ttl = 86400;  // 1 day

	const VERTICAL_ID_OTHER = 0;
	const VERTICAL_ID_TV = 1;
	const VERTICAL_ID_VIDEO_GAMES = 2;
	const VERTICAL_ID_BOOKS = 3;
	const VERTICAL_ID_COMICS = 4;
	const VERTICAL_ID_LIFESTYLE = 5;
	const VERTICAL_ID_MUSIC = 6;
	const VERTICAL_ID_MOVIES = 7;

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
	const CATEGORY_ID_TV = 21;
	const CATEGORY_ID_VIDEOGAMES = 22;
	const CATEGORY_ID_BOOKS = 23;
	const CATEGORY_ID_COMICS = 24;
	const CATEGORY_ID_FANON = 25;
	const CATEGORY_ID_HOMEANDGARDEN = 26;
	const CATEGORY_ID_MOVIES = 27;
	const CATEFORY_ID_ANIME = 28;

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
	 * getAllCategories
	 *
	 * Get all categories and properties of those categories
	 *
	 * @access public
	 *
	 * @param $new boolean flag to return old OR new categories, by default load the old ones while we are in transition phase
	 * @param $both boolean flag to return old AND new categories, $new must be false for this to work
	 * @return array category names and ids from city_cats table
	 */
	public function getAllCategories( $new = false, $both = false ) {

		if (empty($this->mNewCategories) || empty($this->mOldCategories)) {
			$this->loadCategories();
		}

		if ( $new ) {
			return $this->mNewCategories;
		} else if ( $both ) {
			// return both old and new
			return $this->mAllCategories;
		} else {
			// Deprecated/old categories
			return $this->mOldCategories;
		}
	}

	/**
	 * getAllVerticals
	 *
	 * Get all verticals and properties of those verticals
	 */

	public function getAllVerticals() {

		$verticals = (new WikiaSQL())
			->SELECT()
				->FIELD( "vertical_id as id")
				->FIELD( "vertical_name as name")
				->FIELD( "vertical_url as url")
				->FIELD( "vertical_short as short")
			->FROM( "city_verticals" )
			->cache ( $this->cache_ttl, wfSharedMemcKey(__METHOD__) )
			->runLoop( $this->getSharedDB(), function ( &$result, $row)  {
				$result[$row->id] = get_object_vars($row);
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
			->JOIN ( "city_cat_mapping" )->USING( "cat_id" )
			->WHERE( "city_id" )->EQUAL_TO( $city_id )
			->AND_( "cat_deprecated" )->EQUAL_TO ( 1 )  // always return the "old" category
			->cache( $this->cache_ttl, wfSharedMemcKey( __METHOD__, $city_id ), true /* $cacheEmpty */ )
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
		$id = (new WikiaSQL())
			->SELECT( "city_vertical" )
			->FROM( "city_list" )
			->WHERE ("city_id")->EQUAL_TO( $city_id )
			->cache( $this->cache_ttl, wfSharedMemcKey( __METHOD__, $city_id ) )
			->run( $this->getSharedDB(), function( $result ) { return $result->fetchObject(); });

		return $id->city_vertical;
	}

	public function getVerticalNameMessage( $verticalId ) {
		$message = false;
		$verticals = $this->getAllVerticals();
		if ( isset( $verticals[$verticalId] ) ) {
			/*
			 * Possible message keys: vertical-tv, vertical-games, vertical-books, vertical-comics,
			 * vertical-lifestyle, vertical-music, vertical-movies
			 */
			$message = wfMessage( 'vertical-' . $verticals[$verticalId]['short'] );
		}

		return $message;
	}

	/**
	 * Similar to getWikiCategories, this gets the vertical id and metadata for one wiki
	 * Uses the getAllVerticals() function as a helper, which is a little inefficient, but it is
	 *   cached globally for all wikis so it should always be in cache
	 * @param  int $city_id
	 * @return array of "id", "name", "short", "url" mapping
	 */
	public function getWikiVertical( $city_id ) {
		$vertical_id = $this->getVerticalId( $city_id );
		$all_verticals = $this->getAllVerticals();
		$vertical = $all_verticals[$vertical_id];
		$vertical["id"] = $vertical_id;

		return $vertical;
	}

	/**
	 * getCategoryIds  This is the NEW function to use
	 *
	 * get list of (just) category ids for given wiki
	 *
	 * @access public
	 *
	 * @param $city_id
	 * @param int $active pass 0 if you want to get deprecated categories
	 * @return array array of categories (empty if wiki is not in a category)
	 */
	public function getCategoryIds( $city_id, $active = 1 ) {
		global $wgExternalSharedDB;
		if( !$wgExternalSharedDB || empty($city_id) ) {
			return array();
		}

		$categories = (new WikiaSQL())
			->SELECT( "cat_id" )
			->FROM( "city_cats" )
			->JOIN ( "city_cat_mapping" )->USING( "cat_id" )
			->WHERE( "city_id" )->EQUAL_TO( $city_id )
			->AND_( "cat_active" )->EQUAL_TO ( $active )
			->cache( $this->cache_ttl, wfSharedMemcKey( __METHOD__, $city_id, "$active" ) )
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
	 * @param int $active pass 0 if you want to get deprecated categories
	 * @return array of keys/values (id, name, url, short, deprecated, active)
	 */
	public function getWikiCategories( $city_id, $active = 1 ) {
		// invalidated in clearCache method
		$memckey = wfSharedMemcKey( __METHOD__, $city_id, $active ? 1 : 0 );

		// query instead of lookup in AllCategories list
		$categories = (new WikiaSQL())
			->SELECT( "*" )
			->FROM( "city_cats" )
			->JOIN ( "city_cat_mapping" )->USING( "cat_id" )
			->WHERE( "city_id ")->EQUAL_TO( $city_id )
			->AND_( "cat_active" )->EQUAL_TO ( $active )
			->cache( $this->cache_ttl, $memckey, true /* $cacheEmpty */ )
			->runLoop( $this->getSharedDB(), function ( &$result, $row)  {
				$result[] = get_object_vars($row);
			});

		return $categories;

	}

	/**
	 * Gets list of wiki category names
	 *
	 * @param Int $cityId CityId
	 * @param Int $active Active status of categories to return
	 * @return array Array of wiki category names
	 */
	public function getWikiCategoryNames( $cityId, $active = 1 ) {
		$wikiCategoryNames = [];
		$categories = $this->getWikiCategories( $cityId, $active );
		foreach( $categories as $category ) {
			$wikiCategoryNames[] = $category['cat_short'];
		}
		return $wikiCategoryNames;
	}


	/**
	 * get single category name for a wiki
	 * This is deprecated, use getWikiCategories instead
	 * @deprecated
	 */
	public function getCategoryName( $city_id ) {
		$cat_id = $this->getCategoryId( $city_id );
		$categories = $this->getAllCategories(false);
		return isset( $categories[ $cat_id ] )
			? $categories[ $cat_id ]["name"]
			: null;
	}

	/**
	 * get single "short" category name for a wiki
	 * This is deprecated, use getWikiCategories instead
	 * @param  [type] $city_id [description]
	 * @return [type]          [description]
	 * @deprecated
	 */
	public function getCategoryShort( $city_id ) {
		$cat_id = $this->getCategoryId( $city_id );
		$categories = $this->getAllCategories(false);
		return isset( $categories[ $cat_id ] )
			? $categories[ $cat_id ]["short"]
			: null;
	}

	/**
	 * Get a category by name.
	 *
	 * Deprecated. This is only for backwards compatibility.
	 *
	 * @param string $name
	 * @return array the category
	 */
	public function getCategoryByName( $name ) {
		$categories = $this->getAllCategories( false );

		foreach ( $categories as $categoryId => $category ) {
			if ( strcasecmp( $name, $category['name'] ) === 0 ) {
				$category['id'] = $categoryId;
				return $category;
			}
		}

		return null;
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
			->cache ( $this->cache_ttl, wfSharedMemcKey( __METHOD__ ))  // global cache
			->runLoop( $this->getSharedDB(), function (&$result, $row) {
				$arr = get_object_vars($row);
				$result['all'][$row->id] = $arr;
				if ($row->active) {
					$result['active'][$row->id] = $arr;
				}
				if ($row->deprecated) {
					$result['deprecated'][$row->id] = $arr;
				}
			} );

		$this->mAllCategories = $categories['all'];
		$this->mOldCategories = $categories['deprecated'];
		$this->mNewCategories = $categories['active'];

	}

	/**
	 * setVertical
	 * update the vertical for the wiki
	 *
	 * @param integer   $city_id     identifier from city_list
	 * @param integer   $vertical_id vertical identifier
	 * @param string    $reason      optional extra reason string for logging
	 */

	public function setVertical ( $city_id, $vertical_id, $reason) {

		( new WikiaSQL() )
			->UPDATE( 'city_list' )
				->SET( 'city_vertical', $vertical_id )
			->WHERE( 'city_id' )->EQUAL_TO( $city_id )
			->run( $this->getSharedDB( DB_MASTER ) );

		$this->clearCache( $city_id );

		if( !empty($reason) ) {
			$reason = " ( $reason )";
		}
		// I guess we should look up the name here
		$verticals = $this->getAllVerticals();
		$name = $verticals[$vertical_id]['name'];
		WikiFactory::log( WikiFactory::LOG_CATEGORY, "Vertical changed to $name. $reason", $city_id );
	}

	/**
	 * Given an array of category ids, set the wiki to be in those categories.
	 * Also delete any categories that the wiki WAS in.
	 * @param  [type] $city_id    [description]
	 * @param  array  $categories [description]
	 * @return [type]             [description]
	 */

	public function updateCategories ( $city_id, array $categories, $reason ) {
		global $wgExternalSharedDB;

		$values = array();
		// MySQL style multi-row insert
		foreach ($categories as $category) {
			$values[]= ["city_id" => $city_id, "cat_id" => $category];
		}

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		// Clear categories, add any new ones
		// Note: this allows a wiki to be in zero categories, which may affect other biz logic
		$dbw->begin();
		$dbw->delete( "city_cat_mapping", array( "city_id" => $city_id ), __METHOD__ );
		if (!empty ( $values) ) {
			$dbw->insert( "city_cat_mapping", $values, __METHOD__  );
		}
		$dbw->commit();

		$this->clearCache( $city_id );

		# pretty clunky way to load all the categories just for the name, maybe refactor this?
		$this->loadCategories();
		$cat_names = array();
		foreach ($categories as $id) {
			$cat_names[] = $this->mAllCategories[$id]['name'];
		}
		$message = join(", ", $cat_names);
		if( !empty($reason) ) {
			$reason = " ( $reason )";
		}

		WikiFactory::log( WikiFactory::LOG_CATEGORY, "Categories changed to $message. $reason", $city_id );
	}

	// Add 1 category
	public function addCategory ( $city_id, $category ) {

		( new WikiaSQL() )
			->INSERT( 'city_cat_mapping' )
				->SET( 'city_id', $city_id )
				->SET( 'cat_id', $category )
			->run( $this->getSharedDB( DB_MASTER ) );

	}

	// Remove 1 category
	public function removeCategory ( $city_id, $category ) {

		( new WikiaSQL() )
			->DELETE( 'city_cat_mapping' )
				->WHERE( 'city_id', $city_id )
				->AND( 'cat_id', $category )
			->run( $this->getSharedDB( DB_MASTER ) );

	}

	/**
	 * On updating anything related to city verticals or city categories, purge
	 * @param  [type] $city_id [description]
	 * @return none
	 */
	public function clearCache($city_id) {
		global $wgMemc;

		$wgMemc->delete( wfSharedMemcKey("WikiFactoryHub::loadCategories") );

		// Extra : is added to make keys that look like __METHOD__ calls
		$functionNames = [ "getVerticalId", "getCategoryId"];
		foreach ($functionNames as $name) {
			$wgMemc->delete( wfSharedMemcKey("WikiFactoryHub:", $name, $city_id ) );
		}

		$functionNames = [ "getCategoryIds", "getWikiCategories" ];
		foreach ($functionNames as $name) {
			$wgMemc->delete( wfSharedMemcKey("WikiFactoryHub:", $name, $city_id, 0 ) );
			$wgMemc->delete( wfSharedMemcKey("WikiFactoryHub:", $name, $city_id, 1 ) );
		}
	}

	/**
	 *
	 * @param integer $id category id
	 * @return category data
	 *
	 * Pretty sure this function is unused?
	 */
	public function getCategory($id, $new = false) {
		$categories = $this->getAllCategories($new);
		return $categories[$id];
	}
}
