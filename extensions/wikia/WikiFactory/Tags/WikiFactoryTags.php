<?php

/**
 * @package MediaWiki
 * @ingroup WikiFactory
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia Inc.
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 *
 * @see http://www.pui.ch/phred/archives/2005/04/tags-database-schemas.html
 */

// use tables
//
//	CREATE TABLE `city_tag` (
//	  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
//	  `name` varchar(255) DEFAULT NULL,
//	  PRIMARY KEY (`id`),
//	  UNIQUE KEY `city_tag_name_uniq` (`name`)
//	) ENGINE=InnoDB;
//
//	CREATE TABLE `city_tag_map` (
//	  `city_id` int(9) NOT NULL,
//	  `tag_id` int(8) unsigned NOT NULL,
//	  PRIMARY KEY (`city_id`,`tag_id`),
//	  KEY `tag_id` (`tag_id`),
//	  CONSTRAINT FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
//	  CONSTRAINT FOREIGN KEY (`tag_id`) REFERENCES `city_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//	) ENGINE=InnoDB;
//
//

global $wgAjaxExportList;
$wgAjaxExportList[] = "WikiFactoryTags::axQuery";

class WikiFactoryTags {

	private $mCityId;

	/**
	 * public constructor
	 *
	 * @access public
	 * @param integer $city_id	city_id value from city_list table
	 */
	public function __construct( $city_id ) {
		$this->mCityId = $city_id;
	}

	/**
	 *
	 * @access private
	 *
	 * @return string  key used for caching
	 */
	private function cacheKey( ) {
		return sprintf( "wikifactory:tags:v1:%d", $this->mCityId );
	}


	/**
	 *
	 * clear Tags cache
	 *
	 * @access public
	 */
	public function clearCache() {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		if( $this->mCityId ) {
			$wgMemc->delete( $this->cacheKey() );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * getTags -- get all tags defined from database mapped to current wiki
	 *
	 * @access public
	 */
	public function getTags( $skipcache = false ) {

		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$result = array();

		/**
		 * try cache first
		 */
		if( !$skipcache ) {
			/**
			 * check if cache has any values stored
			 */
			$result = $wgMemc->get( $this->cacheKey() );
			$usedb  = is_array( $result ) ? false : true;
		}
		else {
			$usedb = true;
		}

		if( $usedb ) {
			$dbr = WikiFactory::db( DB_SLAVE );
			$sth = $dbr->select(
				array( "city_tag", "city_tag_map" ),
				array( "tag_id", "name" ),
				array( "tag_id = id", "city_id" => $this->mCityId ),
				__METHOD__,
				array( "ORDER BY" => "name" )
			);
			while( $row = $dbr->fetchObject( $sth ) ) {
				$result[ $row->tag_id ] = $row->name;
			}

			/**
			 * set in cache for future use
			 */
			$wgMemc->set( $this->cacheKey(), $result, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * getTags -- get all tags defined from database mapped to current wiki
	 *
	 * @access public
	 */
	public function getAllTags( $skipcache = false ) {

		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$result = array();
		$result[ "byid"   ] = array();
		$result[ "byname" ] = array();

		/**
		 * try cache first
		 */
		if( !$skipcache ) {
			/**
			 * check if cache has any values stored
			 */
			$result = $wgMemc->get( $this->cacheKey() );
			$usedb  = is_array( $result ) ? false : true;
		}
		else {
			$usedb = true;
		}

		if( $usedb ) {
			$dbr = WikiFactory::db( DB_SLAVE );
			$sth = $dbr->select(
				array( "city_tag"  ),
				array( "id", "name" ),
				'',
				__METHOD__
			);
			while( $row = $dbr->fetchObject( $sth ) ) {
				$result[ "byid"   ][ $row->id   ] = $row->name;
				$result[ "byname" ][ $row->name ] = $row->id;
			}

			/**
			 * set in cache for future use
			 */
			$wgMemc->set( $this->cacheKey(), $result, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * use provided string to add new tags into database. Tags will be:
	 *
	 * 1) lowercased
	 * 2) splitted by space
	 * 3) added to city_tag table if they are not exist already
	 * 4) added to city_tag_map
	 *
	 * @access public
	 *
	 * @param string $stag string with tag definition
	 *
	 * @return Array current tags for wiki
	 */
	public function addTagsByName( $stag ) {

		if( !$this->mCityId ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		$tags = explode( " ", trim( strtolower( $stag ) ) );
		$dbw  = WikiFactory::db( DB_MASTER );

		/**
		 * check if all tags are already defined in database,
		 *
		 * if not - add them and get id value
		 * if yes - just get id value
		 *
		 */
		$ids = array();
		foreach( $tags as $tag ) {
			$row = $dbw->selectRow(
				array( "city_tag" ),
				array( "*" ),
				array( "name" => $tag ),
				__METHOD__
			);

			if( !empty( $row->id ) ) {
				$ids[] = $row->id;
			}
			else {
				/**
				 * add new tag to database
				 */
				$dbw->insert(
					"city_tag",
					array( "name"=> $tag ),
					__METHOD__
				);
				$ids[] = $dbw->insertId();
			}
		}

		wfProfileOut( __METHOD__ );

		/**
		 * add tags by id, refresh cache, return defined tags
		 */
		return $this->addTagsById( $ids );
	}

	/**
	 * use provided array to add new tags into database.
	 *
	 * @param Array $ids
	 *
	 * @return Array current tags for wiki
	 */
	public function addTagsById( $ids ) {

		if( !$this->mCityId ) {
			return false;
		}

		/**
		 * and now map tags in city_tag_map
		 */
		wfProfileIn( __METHOD__ );

		$dbw = WikiFactory::db( DB_MASTER );
		if( is_array( $ids ) ) {
			foreach( $ids as $id ) {
				$dbw->replace(
					"city_tag_map",
					array( "city_id", "tag_id" ),
					array( "city_id" => $this->mCityId, "tag_id" => $id ),
					__METHOD__
				);
			}
		}
		wfProfileOut( __METHOD__ );

		/**
		 * refresh cache, return defined tags
		 */
		return $this->getTags( true );
	}

	/**
	 * use provided string to remove tags from database. Tags will be:
	 *
	 * 1) splitted by space
	 * 2) lowercased
	 * 3) removed from city_tag_map
	 * 4) leaved in city_tag
	 *
	 * @access public
	 *
	 * @param string $stag string with tag definition
	 *
	 * @return Array current tags for wiki
	 */
	public function removeTagsByName( $stag ) {

		if( !$this->mCityId ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		$tags = explode( " ", trim( strtolower( $stag ) ) );
		$dbw  = WikiFactory::db( DB_MASTER );

		$ids = array();
		foreach( $tags as $tag ) {
			$row = $dbw->selectRow(
				array( "city_tag" ),
				array( "*" ),
				array( "name" => $tag ),
				__METHOD__
			);

			if( !empty( $row->id ) ) {
				$ids[] = $row->id;
			}
		}

		wfProfileOut( __METHOD__ );
		return $this->removeTagsById( $ids );
	}

	/**
	 * use provided array to remove tags from database.
	 *
	 * @access public
	 * @param Array $ids
	 *
	 * @return Array current tags for wiki
	 */
	public function removeTagsById( $ids ) {

		if( !$this->mCityId ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		$dbw  = WikiFactory::db( DB_MASTER );

		if( is_array( $ids ) ) {
			foreach( $ids as $id ) {
				$dbw->delete(
					"city_tag_map",
					array( "city_id" => $this->mCityId, "tag_id" => $id ),
					__METHOD__
				);
			}
		}

		wfProfileOut( __METHOD__ );

		/**
		 * refresh cache, return defined tags
		 */
		return $this->getTags( true );
	}

	/**
	 * remove all tags defined for wiki
	 *
	 * @access public
	 *
	 * @return boolean -- status of operation
	 */
	public function removeTagsAll( ) {
		wfProfileIn( __METHOD__ );

		$dbw  = WikiFactory::db( DB_MASTER );
		$status = $dbw->delete(
			"city_tag_map",
			array( "city_id" => $this->mCityId ),
			__METHOD__
		);

		#did changes, clear old values
		$this->clearCache();

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * get tag name by using its id
	 *
	 * @access public
	 * @static
	 *
	 * @return Integer tag id or false
	 */
	static public function nameFromId( $id ) {
		$tags = new WikiFactoryTags( 0 );
		$tags = $tags->getAllTags();
		return isset( $tags["byid"][ $id ] ) ? $tags["byid"][ $id ] : false;
	}

	/**
	 * get tag id by using its name
	 *
	 * @access public
	 * @static
	 *
	 * @return string tag name or false
	 */
	static public function idFromName( $name ) {
		$tags = new WikiFactoryTags( 0 );
		$tags = $tags->getAllTags();
		return isset( $tags["byname"][ $name ] ) ? $tags["byname"][ $name ] : false;
	}

	/**
	 * used in autocompleting form
	 *
	 * @access public
	 * @static
	 *
	 * @return String json-ized answer
	 */
	static public function axQuery() {
		global $wgRequest;
		$query = $wgRequest->getVal( "query", false );

		$return = array(
				"query"       => $query,
				"suggestions" => array(),
				"data"        => array()
		);

		if( $query ) {
			$query = strtolower( $query );
			$dbr = WikiFactory::db( DB_SLAVE );
			$sth = $dbr->select(
				array( "city_tag" ),
				array( "id", "name" ),
				array( "name like '%{$query}%'" ),
				__METHOD__
			);
			while( $row = $dbr->fetchObject( $sth ) ) {
				$return[ "suggestions" ][] = $row->name;
			}
		}

		return Wikia::json_encode( $return );
	}
}
