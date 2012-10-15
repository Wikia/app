<?php

/**
 * TODO: doc
 * 
 * @since 0.1
 * 
 * @ingroup Distribution
 * 
 * @author Chad Horohoe
 */
class ReleaseRepo {

	private static $_i = null;
	private $fullyLoaded = false;
	private $releases, $supported = null;
	const CACHE_KEY = 'mediawiki-release-list';

	protected function __construct() {

	}

	public static function singleton() {
		if( is_null( self::$_i ) ) {
			self::$_i = new self();
		}
		return self::$_i;
	}

	protected function clearCache() {
		global $wgMemc;
		$wgMemc->delete( self::CACHE_KEY );
	}

	public function getLatestStableRelease() {
		$this->load();
		return reset( $this->releases );
	}

	public function getSupportedReleases() {
		if( is_null( $this->supported ) ) {
			$this->load();
			$this->supported = array();
			foreach( $this->releases as $rel ) {
				if( $rel->isSupported() ) {
					$this->supported[] = $rel;
				}
			}
		}
		return $this->supported;
	}

	public function releaseExists( $id ) {
		$this->load();
		return isset( $this->releases[$id] );
	}

	public function getReleaseForId( $id ) {
		if( $this->releaseExists( $id ) ) {
			return $this->releases[$id];
		}
		return null;
	}

	public function getAllReleases() {
		$this->load();
		return $this->releases;
	}

	private function load() {
		if( !is_null( $this->releases ) ) {
			return;
		} else {
			global $wgMemc;
			$res = $wgMemc->get( self::CACHE_KEY );
			if( $res ) {
				$this->releases = $res;
			} else {
				$dbr = wfGetDB( DB_SLAVE );
				$this->releases = array();
				$res = $dbr->select( 'distribution_mwreleases', '*', array(), __METHOD__ );
				foreach( $res as $row ) {
					if( !isset( $this->releases[$row->mwr_id] ) ) {
						$mw = MediaWikiRelease::newFromRow( $row );
						$this->releases[$mw->getId()] = $mw;
					}
				}
				uasort( $this->releases, array( $this, 'sortReleasesDesc' ) );
				// cache for 30 days. This doesn't change often so we'll explicity
				// flush when we've changed something
				$wgMemc->set( self::CACHE_KEY, $this->releases, 60 * 60 * 24 * 30 );
			}
			$this->fullyLoaded = true;
		}
	}

	private function sortReleasesDesc( $relA, $relB ) {
		return version_compare( $relA->getNumber(), $relB->getNumber(), '<' );
	}
}
