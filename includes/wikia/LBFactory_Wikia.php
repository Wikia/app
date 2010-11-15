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
		} elseif( $smwgUseExternalDB && substr($dbName, 0, 4 ) == "smw+" && isset( $this->sectionsByDB[ "smw+" ] ) ) {
			$section = "smw";
			/**
			 * overwrite database name using templateOverridesByServer
			 */
			wfDebugLog( "connect", __METHOD__ . ": section smw choosen for $wiki\n" );
			foreach( $this->sectionLoads[ $section ] as $server ) {
				if( !is_array( $this->templateOverridesByServer[ $server ] ) ) {
					 $this->templateOverridesByServer[ $server ] = array();
				}
				$this->templateOverridesByServer[ $server ][ "dbname" ] = $wgDBname;
				wfDebugLog( "connect", __METHOD__ . ": overwritting dbname $wgDBname for $server in templateOverridesByServer\n" );
			}
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
		wfDebugLog( "connect", __METHOD__ . ": section {$this->lastSection}, wiki {$this->lastWiki}\n" );

		return $section;
	}

}
