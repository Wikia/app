<?php
/**
 * @file
 * @ingroup Database
 */

/**
 * A multi-wiki, multi-master factory for Wikia and similar installations.
 * Ignores the old configuration globals
 *
 * @ingroup Database
 */
class LBFactory_Wikia extends LBFactory_Multi {

	function getSectionForWiki( $wiki = false ) {
		global $wgDBname, $wgDBcluster, $smwgUseExternalDB;

		if ( $this->lastWiki === $wiki ) {
			return $this->lastSection;
		}
		list( $dbName, $prefix ) = $this->getDBNameAndPrefix( $wiki );
		if ( isset( $this->sectionsByDB[$dbName] ) ) {
			// this is a db that has a cluster defined in the config file (DB.php)
			$section = $this->sectionsByDB[$dbName];
		} elseif ( $dbName == $wgDBname ) {
			// this is a local db so use global variables
			if ( isset( $wgDBcluster ) ) {
				$section = $wgDBcluster;
			} else {
				$section = 'DEFAULT';
			}
		} elseif( $smwgUseExternalDB && preg_match("^smw\+\-(.+)", $dbName, $subpatterns )
			&& isset( $this->sectionsByDB[ "smw+" ] ) ) {
			$section = "smw+";
			$wiki = substr( $wiki, 4 );
		} else {
			// this is a foreign db that either has a cluster defined in WikiFactory...
			$section = WikiFactory::getVarValueByName( 'wgDBcluster', WikiFactory::DBtoID( $wiki ) );
			if ( empty( $section ) ) {
				// ...or not
				$section = 'DEFAULT';
			}
		}
		$this->lastSection = $section;
		$this->lastWiki = $wiki;
		return $section;
	}

}
