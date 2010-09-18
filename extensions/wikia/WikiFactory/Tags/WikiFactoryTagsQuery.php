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

class WikiFactoryTagsQuery {

	private
		$mTags,
		$mConditions,
		$mCachedTags;

	/**
	 * constructor
	 *
	 * @access public
	 *
	 * @param Mixed $tags       -- array of strings or string
	 * @param Array $conditions -- other conditions (agains city_list) like
	 *                             languages etc
	 */
	public function __construct( $tags, $conditions = false ) {
		$this->mTags = $tags;
		$this->mConditions = $conditions;
	}


	/**
	 * simple query builder
	 *
	 * @access public
	 *
	 * @return Array array of city_id values
	 */
	public function doQuery() {

		wfProfileIn( __METHOD__ );

		/**
		 * initialize
		 */
		$result = array();
		$this->getTags();
		$dbr = WikiFactory::db( DB_SLAVE );

		if( is_string( $this->mTags ) )  {
			/**
			 * single tag, simple query
			 */
			if( isset( $this->mCachedTags[ $this->mTags ] ) ) {
				$sth = $dbr->select(
					array( "city_tag_map" ),
					array( "city_id" ),
					array( "tag_id" => $this->mCachedTags[ $this->mTags ] ),
					__METHOD__
				);
				while( $row = $dbr->fetchObject( $sth ) ) {
					$result[] = $row->city_id;
				}
			}
		}
		elseif( is_array( $this->mTags ) ) {
			/**
			 * get maps for required tags, when one of tag is not found result
			 * is empty (because it's boolean AND condition)
			 */
			$ids = array();
			foreach( $this->mTags as $tag ) {
				if( isset( $this->mCachedTags[ $tag ] ) ) {
					$ids[] = $this->mCachedTags[ $tag ];
				}
				else {
					/**
					 * missing tag, ignore or empty result? -- so far ignore
					 */
				}
			}

#			$sth = $dbr-

		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * get all defined tags from city_tag list
	 */
	private function getTags( ) {
		global $wgMemc;

		if( isset( $this->mCachedTags ) && is_array( $this->mCachedTags ) ) {
			return $this->mCachedTags;
		}
		wfProfileIn( __METHOD__ );
		/**
		 * first from cache, cache is set for 1h
		 */
		$this->mCachedTags = $wgMemc->get( $this->cacheKey() );
		if( !isset( $this->mCachedTags ) || !is_array( $this->mCachedTags ) ) {
			/**
			 * if not success then from database
			 */
			$dbr = WikiFactory::db( DB_SLAVE );
			$sth = $dbr->select(
				array( "city_tag" ),
				array( "*" ),
				false,
				__METHOD__
			);
			while( $row = $dbr->fetchObject( $sth ) ) {
				$this->mCachedTags[ $row->name ] = $row->id;
			}
			/**
			 * store for hour
			 */
			$wgMemc->set( $this->cacheKey(), $this->mCachedTags, 3600 );
		}

		wfProfileOut( __METHOD__ );

		return $this->mCachedTags;
	}

	/**
	 *
	 * @access private
	 *
	 * @return string  key used for caching
	 */
	private function cacheKey( ) {
		return "wikifactory:tags:map";
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

		$wgMemc->delete( $this->cacheKey() );

		wfProfileOut( __METHOD__ );
	}


}
