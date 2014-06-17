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
class WikiFactoryHub {

	#--- static variables
	private static $mInstance = false;
	private static $mCategories = array();

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
	private function __construct( ) {
		self::$mCategories = $this->loadCategories();
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
	 * getBreadCrumb
	 *
	 * get category structure using global function
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 * @author Emil Podlaszewski <emil@wikia.com>
	 *
	 * @param $city_id
	 * @return array An array with categories
	 */
	public function getBreadCrumb( $city_id ) {
		global $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$cat_id = $dbr->selectField(
			"city_cat_mapping",
			"cat_id",
			array( "city_id" => $city_id )
		);

		$cats = array();
		while( !empty( $cat_id ) ) {
			$res = $dbr->select(
				array( "city_cat_structure", "city_cats" ),
				array( "cat_name", "cat_url", "cat_parent_id" ),
				array( "city_cat_structure.cat_id=city_cats.cat_id", "city_cat_structure.cat_id={$cat_id}" )
			);
			if( $row = $dbr->fetchObject( $res ) ) {
				$cats[] = array( "name" => $row->cat_name, "url" => $row->cat_url, "id" => intval( $cat_id ), "parentId" => intval( $row->cat_parent_id ) );
				$cat_id = $row->cat_parent_id;
			}
		}
		wfProfileOut( __METHOD__ );

		$cats = array_reverse( $cats );

		return $cats;
	}

	/**
	 * return HTML select for category choosing
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
			"categories" 	=> self::$mCategories
		));

		return $oTmpl->render("categories");
	}

	/**
	 * return HTML select for category choosing
	 */
	public function getSelect( $cat_id ) {

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title"			=> null,
			"cat_id"		=> $cat_id,
			"categories" 	=> self::$mCategories
		));

		return $oTmpl->render("categories");
	}

	/**
	 * getCategories
	 *
	 * get category identifier for given wiki
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @return array	category names and ids from
	 */
	public function getCategories( ) {
		return self::$mCategories;
	}

	/**
	 * getCategoryId
	 *
	 * get category identifier for given wiki
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param $city_id
	 * @return integer category id from city_cat_mapping table
	 */
	public function getCategoryId( $city_id ) {
		global $wgExternalSharedDB, $wgMemc;

		wfProfileIn( __METHOD__ );

		$memkey = sprintf("%s:%d", __METHOD__, $city_id);
		$cat_id = $wgMemc->get($memkey);
		if ( empty( $cat_id ) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			$oRow = $dbr->selectRow(
				array( "city_cat_mapping" ),
				array( "cat_id" ),
				array( "city_id" => $city_id ),
				__METHOD__
			);
			$cat_id = isset( $oRow->cat_id ) ? $oRow->cat_id : null ;
			if ( $cat_id ) $wgMemc->set( $memkey, $cat_id, 60 * 60 * 24 );
		}

		wfProfileOut( __METHOD__ );

		return $cat_id;
	}

	/**
	 * get category name
	 */
	public function getCategoryName( $city_id ) {
		$cat_id = $this->getCategoryId( $city_id );
		return isset( self::$mCategories[ $cat_id ] )
			? self::$mCategories[ $cat_id ]["name"]
			: null;
	}
	public function getCategoryShort( $city_id ) {
		$cat_id = $this->getCategoryId( $city_id );
		return isset( self::$mCategories[ $cat_id ] )
			? self::$mCategories[ $cat_id ]["short"]
			: null;
	}
	/**
	 * loadCategories
	 *
	 * load data from database: city_cats (WF)
	 *
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @return array	array with category maps id => name
	 */
	private function loadCategories() {
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

	/**
	 * getIdByName
	 *
	 * get category id for hub using category name
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
	 *
	 * @param string $name
	 * @return integer category id
	 */
	public function getIdByName( $name ) {
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$oRow = $dbr->selectRow(
			array( "city_cats" ),
			array( "cat_id" ),
			array( "cat_name" => htmlspecialchars( $name ) ),
			__METHOD__
		);

		$id = isset( $oRow->cat_id ) ? $oRow->cat_id : false;

		wfProfileOut( __METHOD__ );

		return $id;
	}

	/**
	 * setCategory
	 *
	 * remove previous value in database and insert new one
	 *
	 * @param integer   $city_id    identifier from city_list
	 * @param integer   $cat_id     category identifier
	 * @param string    $reason     optional extra reason string for logging
	 */
	public function setCategory( $city_id, $cat_id, $reason='' ) {
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->begin();
		$dbw->delete( "city_cat_mapping", array( "city_id" => $city_id ), __METHOD__ );
		$dbw->insert( "city_cat_mapping", array( "city_id" => $city_id, "cat_id" => $cat_id ), __METHOD__  );

		$categories = $this->getCategories();
		if( !empty($reason) ) {
			$reason = " (" . (string)$reason . ")";
		}
		WikiFactory::log( WikiFactory::LOG_CATEGORY, "Category changed to {$categories[$cat_id]['name']}".$reason, $city_id );

		$dbw->commit();

		wfProfileOut( __METHOD__ );
	}

	/**
	 *
	 * @param integer $id category id
	 * @return array of category id
	 */
	public function getCategory($id) {
		return self::$mCategories[$id];
	}

	/**
	 * Get category by name. Searches through list of categories.
	 * @param string $name category name
	 * @return array of category data, including id
	 */
	public function getCategoryByName($name) {
		foreach (self::$mCategories as $categoryId=>$category) {
			if (strcasecmp($name, $category['name']) == 0) {
				$category['id'] = $categoryId;
				return $category;
			}
		}

		return null;
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
