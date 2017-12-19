<?php

/**
 * @author: Federico "Lox" Lucignano
 *
 * A helper class for the IP rename tool
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 3.0 or later
 */
class RenameIPHelper {

	const CLUSTER_DEFAULT = '';

	/**
	 * @author Federico "Lox" Lucignano
	 * @param $userID int the registered user ID
	 * @return Array A list of wikis' IDs related to user activity, false if the user is not an existing one or an anon
	 *
	 * Finds on which wikis a REGISTERED user (see LookupContribs for anons) has been active using the events table stored in the stats DB
	 * instead of the blobs table in dataware, tests showed is faster and more accurate
	 */
	static public function lookupRegisteredUserActivity( $userID ) {
		global $wgDevelEnvironment, $wgStatsDB, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );

		// check for non admitted values
		if ( empty( $userID ) || !is_int( $userID ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfDebugLog( __CLASS__ . '::' . __METHOD__, "Looking up registered user activity for user with ID {$userID}" );

		$result = [];
		if ( empty( $wgDevelEnvironment ) ) { // on production
			if ( !empty( $wgStatsDBEnabled ) ) {
				$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
				$res = $dbr->select( 'events', 'wiki_id', ['user_id' => $userID], __METHOD__, ['GROUP BY' => 'wiki_id'] );

				while ( $row = $dbr->fetchObject( $res ) ) {
					if ( WikiFactory::isPublic( $row->wiki_id ) ) {
						$result[] = (int)$row->wiki_id;
						wfDebugLog( __CLASS__ . '::' . __METHOD__, "Registered user with ID {$userID} was active on wiki with ID {$row->wiki_id}" );
					} else {
						wfDebugLog( __CLASS__ . '::' . __METHOD__, "Skipped wiki with ID {$row->wiki_id} (inactive wiki)" );
					}
				}

				$dbr->freeResult( $res );
			}
		}
		else { // on devbox - set up the list manually
			$result = array(
				165, // firefly
				831, // muppet
			);
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Gets wikis an IP address might have edits on
	 *
	 * @author Daniel Grunwell (Grunny)
	 *
	 * @param String $ipAddress The IP address to lookup
	 *
	 * @return array
	 */
	public static function lookupIPActivity( $ipAddress ) {
		global $wgDevelEnvironment, $wgSpecialsDB;
		wfProfileIn( __METHOD__ );

		if ( empty( $ipAddress ) || !IP::isIPAddress( $ipAddress ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$result = [];
		$ip = inet_pton( $ipAddress );
		if ( empty( $wgDevelEnvironment ) ) {
			$dbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
			$res = $dbr->select(
				[ 'multilookup' ],
				[ 'ml_city_id' ],
				[
					'ml_ip_bin' => $ip,
				],
				__METHOD__
			);

			foreach ( $res as $row ) {
				if ( WikiFactory::isPublic( $row->ml_city_id ) ) {
					$result[] = (int)$row->ml_city_id;
				}
			}

			$dbr->freeResult( $res );
		} else { // on devbox - set up the list manually
			$result = [
				165, // firefly
			];
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 * @param $wikiCityID int the city_id for the wiki
	 * @return string the name of the cluster the wiki DB belongs to
	 *
	 * Retrieves the name of the cluster in which the local DB for the specified wiki is stored
	 */
	static public function getCityCluster( $wikiCityID ) {
		wfProfileIn( __METHOD__ );

		// check for non admitted values
		if ( empty( $wikiCityID ) || !is_int( $wikiCityID ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfDebugLog( __CLASS__ . '::' . __METHOD__, "Looking up cluster for wiki with ID {$wikiCityID}" );

		// WikiFactory implementation
		$value = WikiFactory::getVarValueByName( 'wgDBcluster', $wikiCityID );

		// if not found fall back to city_list implementation
		if ( empty( $value ) ) {
			$dbr = WikiFactory::db( DB_SLAVE );
			$res = $dbr->selectField( 'city_list', 'city_cluster', array( 'city_id' => $wikiCityID ) );
			$value = $res;
		}

		wfDebugLog( __CLASS__ . '::' . __METHOD__, "Cluster for wiki with ID {$wikiCityID} is '{$value}'" . ( ( empty( $value ) ? ' (main shared DB)' : null ) ) );

		wfProfileOut( __METHOD__ );
		return ( empty( $value ) ) ? self::CLUSTER_DEFAULT : $value;
	}

	/**
	 * testBlock
	 *
	 * performs a test of all available phalanx filters and returns warning message if there are any
	 * @author Kamil Koterba <kamil@wikia-inc.com>
	 *
	 * @param $text String to match
	 * @return String with HTML to display via AJAX
	 */
	public static function testBlock( $text ) {
		wfProfileIn( __METHOD__ );

		if ( !class_exists( 'PhalanxService' ) ) {
			wfProfileOut( __METHOD__ );
			return '';
		}

		$phalanxMatchParams = PhalanxMatchParams::withGlobalDefaults()->content( $text );
		$phalanxService = PhalanxServiceFactory::getServiceInstance();

		$blockFound = false;

		foreach ( Phalanx::getSupportedTypeNames() as $blockType ) {
			$phalanxMatchParams->type( $blockType );
			$res = $phalanxService->doMatch( $phalanxMatchParams );

			if ( !empty( $res ) ) {
				$blockFound = true;
				break;
			}

		}

		$warning = '';
		if ( $blockFound ) {
			$phalanxTestTitle = SpecialPage::getTitleFor( 'Phalanx', 'test' );
			$linkToTest = Linker::link( $phalanxTestTitle, wfMessage( 'coppatool-see-list-of-blocks' )->escaped(), [], [ 'wpBlockText' => $text ] );
			$warning = wfMessage( 'coppatool-warning-phalanx-block', $text )->rawParams( $linkToTest )->escaped();
		}

		wfProfileOut( __METHOD__ );
		return $warning;
	}

}
