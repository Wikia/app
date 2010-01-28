<?php

/**
 * @package MediaWiki
 * @ingroup WikiFactory
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia Inc.
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

# use tables
#
#CREATE TABLE `city_tag` (
#  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
#  `name` varchar(255) DEFAULT NULL,
#  PRIMARY KEY (`id`),
#  UNIQUE KEY `city_tag_name_uniq` (`name`)
#) ENGINE=InnoDB DEFAULT;
#
#
#CREATE TABLE `city_tag_map` (
#  `city_id` int(9) NOT NULL,
#  `tag_id` int(8) unsigned NOT NULL,
#  PRIMARY KEY (`city_id`,`tag_id`),
#  KEY `tag_id` (`tag_id`),
#  CONSTRAINT FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
#  CONSTRAINT FOREIGN KEY (`tag_id`) REFERENCES `city_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
#) ENGINE=InnoDB
#
# http://www.pui.ch/phred/archives/2005/04/tags-database-schemas.html

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
	private function cacheKey() {
		return sprintf( "wikifactory:tags:v1:%d", $this->mCityId );
	}


	/**
	 * getTags -- get all tags defined from database
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
			if( !is_array( $result ) ) {
				$usedb = true;
			}
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
				__METHOD__
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
}
