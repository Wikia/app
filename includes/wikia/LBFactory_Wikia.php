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

	function __construct( $conf ) {
		self::normalizeMultipleMasters( $conf );

		parent::__construct( $conf );
	}

	/**
	 * Normalize the list of multiple masters and slaves
	 *
	 * @param array $sectionLoads
	 * @author macbre
	 * @see PLATFORM-434
	 */
	static function normalizeMultipleMasters( Array &$conf ) {
		foreach ( $conf['sectionLoads'] as $sectionName => &$sectionConf ) {
			# section config has both "masters" and "slaves" section
			if ( isset( $sectionConf['masters'] ) && isset( $sectionConf['slaves'] ) ) {
				# randomize masters server and normalize the section config
				$master = array_rand( $sectionConf['masters'], 1 );

				wfDebug( sprintf( "%s: randomizing master for %s: picked %s\n", __METHOD__, $sectionName, $master ) );

				# make it flat
				$sectionConf = array( $master => $sectionConf['masters'][$master] ) + $sectionConf['slaves'];
			}
		}
	}

	function getSectionForWiki( $wiki = false ) {
		global $wgDBname, $wgDBcluster, $smwgUseExternalDB;

		if ( $this->lastWiki === $wiki ) {
			return $this->lastSection;
		}
		list( $dbName, $prefix ) = $this->getDBNameAndPrefix( $wiki );

		/**
		 * actually we should not have any fallback because it will end with
		 * fatal anyway.
		 *
		 * But it makes PHP happy
		 */
		$section = 'central';

		$this->isSMWClusterActive = false;
		if ( $smwgUseExternalDB ) {
			/**
			 * set flag, strip database name
			 */
			if ( substr( $dbName, 0, 4 ) == "smw+" && isset( $this->sectionsByDB[ "smw+" ] ) ) {
				$this->isSMWClusterActive = true;
				$dbName = substr( $dbName, 4 );
				wfDebugLog( "connect", __METHOD__ . ": smw+ cluster is active, dbname changed to $dbName\n", true );
			}
		}

		if ( isset( $this->sectionsByDB[$dbName] ) ) {
			// this is a db that has a cluster defined in the config file (DB.php)
			$section = $this->sectionsByDB[$dbName];
		}
		elseif ( $this->isSMWClusterActive ) {
			// use smw+ entry
			$section = $this->sectionsByDB[ "smw+" ];
			wfDebugLog( "connect", __METHOD__ . "-smw: section $section choosen for $wiki\n" );
		}
		elseif ( $dbName == $wgDBname ) {
			// this is a local db so use global variables
			if ( isset( $wgDBcluster ) ) {
				$section = $wgDBcluster;
			}
		}
		else {
			// this is a foreign db that either has a cluster defined in WikiFactory...
			$section = WikiFactory::getVarValueByName( 'wgDBcluster', WikiFactory::DBtoID( $wiki ) );
			if ( empty( $section ) ) {
				$section = 'central';
			}
		}
		$this->lastSection = $section;
		$this->lastWiki = $wiki;
		wfDebugLog( "connect", __METHOD__ . ": section {$this->lastSection}, wiki {$this->lastWiki}\n" );

		return $section;
	}
}
