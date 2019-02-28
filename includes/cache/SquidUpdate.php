<?php
/**
 * See deferred.txt
 * @file
 * @ingroup Cache
 */

/**
 * Handles purging appropriate Squid URLs given a title (or titles)
 * @ingroup Cache
 */
class SquidUpdate {
	var $urlArr, $mMaxTitles;

	function __construct( $urlArr = Array(), $maxTitles = false ) {
		global $wgMaxSquidPurgeTitles;
		if ( $maxTitles === false ) {
			$this->mMaxTitles = $wgMaxSquidPurgeTitles;
		} else {
			$this->mMaxTitles = $maxTitles;
		}
		if ( count( $urlArr ) > $this->mMaxTitles ) {
			$urlArr = array_slice( $urlArr, 0, $this->mMaxTitles );
		}
		$this->urlArr = $urlArr;
	}

	/**
	 * @param $title Title
	 *
	 * @return SquidUpdate
	 */
	static function newFromLinksTo( &$title ) {
		global $wgMaxSquidPurgeTitles;
		wfProfileIn( __METHOD__ );

		# Get a list of URLs linking to this page
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( array( 'links', 'page' ),
			array( 'page_namespace', 'page_title' ),
			array(
				'pl_namespace' => $title->getNamespace(),
				'pl_title'     => $title->getDBkey(),
				'pl_from=page_id' ),
			__METHOD__ );
		$blurlArr = $title->getSquidURLs();
		if ( $dbr->numRows( $res ) <= $wgMaxSquidPurgeTitles ) {
			foreach ( $res as $BL ) {
				$tobj = Title::makeTitle( $BL->page_namespace, $BL->page_title ) ;
				$blurlArr[] = $tobj->getInternalURL();
			}
		}

		wfProfileOut( __METHOD__ );
		return new SquidUpdate( $blurlArr );
	}

	/**
	 * Create a SquidUpdate from an array of Title objects, or a TitleArray object
	 *
	 * @param $titles array
	 * @param $urlArr array
	 *
	 * @return SquidUpdate
	 */
	static function newFromTitles( $titles, $urlArr = array() ) {
		global $wgMaxSquidPurgeTitles;
		$i = 0;
		foreach ( $titles as $title ) {
			$urlArr[] = $title->getInternalURL();
			if ( $i++ > $wgMaxSquidPurgeTitles ) {
				break;
			}
		}
		return new SquidUpdate( $urlArr );
	}

	/**
	 * @param $title Title
	 *
	 * @return SquidUpdate
	 */
	static function newSimplePurge( &$title ) {
		$urlArr = $title->getSquidURLs();
		return new SquidUpdate( $urlArr );
	}

	/**
	 * Purges the list of URLs passed to the constructor
	 */
	function doUpdate() {
		SquidUpdate::purge( $this->urlArr );
	}

	/**
	 * Purges a list of Squids defined in $wgSquidServers.
	 * $urlArr should contain the full URLs to purge as values
	 * (example: $urlArr[] = 'http://my.host/something')
	 * XXX report broken Squids per mail or log
	 *
	 * @param $urlArr array
	 * @return void
	 */
	static function purge( $urlArr ) {
		if( $urlArr ) {
			\Wikia\Factory\ServiceFactory::instance()->purgerFactory()->purger()->addUrls( $urlArr );
		}
	}

	/**
	 * Expand local URLs to fully-qualified URLs using the internal protocol
	 * and host defined in $wgInternalServer. Input that's already fully-
	 * qualified will be passed through unchanged.
	 *
	 * This is used to generate purge URLs that may be either local to the
	 * main wiki or include a non-native host, such as images hosted on a
	 * second internal server.
	 *
	 * Client functions should not need to call this.
	 *
	 * @param $url string
	 *
	 * @return string
	 */
	static function expand( $url ) {
		return wfExpandUrl( $url, PROTO_INTERNAL );
	}
}
