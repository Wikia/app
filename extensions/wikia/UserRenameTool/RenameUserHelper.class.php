<?php

class RenameUserHelper {

	const CLUSTER_DEFAULT = '';
	const COMMUNITY_CENTRAL_CITY_ID = 177;

	/**
	 * Finds on which wikis a REGISTERED user (see LookupContribs for anons) has been active
	 * using the events table stored in the stats DB instead of the blobs table in dataware,
	 * tests showed is faster and more accurate
	 *
	 * @param $userID int the registered user ID
	 * @return array A list of wikis' IDs related to user activity, false if the user is not an existing one or an anon
	 */
	static public function lookupRegisteredUserActivity( $userID ) {
		global $wgDevelEnvironment, $wgDWStatsDB, $wgStatsDBEnabled;
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
				$dbr = wfGetDB( DB_SLAVE, array(), $wgDWStatsDB );
				$res = $dbr->select( 'rollup_edit_events', 'wiki_id', ['user_id' => $userID], __METHOD__, ['GROUP BY' => 'wiki_id'] );

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
		} else { // on devbox - set up the list manually
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
	 * @param String $ipAddress The IP address to lookup
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
		$ipLong = ip2long( $ipAddress );

		if ( empty( $wgDevelEnvironment ) ) {
			$dbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
			$res = $dbr->select(
				[ 'multilookup' ],
				[ 'ml_city_id' ],
				[
					'ml_ip' => $ipLong,
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
	 * Performs a test of all available phalanx filters and returns warning message if there are any
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

		$service = new PhalanxService();
		$blockFound = false;

		foreach ( Phalanx::getAllTypeNames() as $blockType ) {
			$res = $service->match( $blockType, $text );

			if ( !empty( $res ) ) {
				$blockFound = true;
				break;
			}
		}

		$warning = '';

		if ( $blockFound ) {
			$phalanxTestTitle = SpecialPage::getTitleFor( 'Phalanx', 'test' );
			$linkToTest = Linker::link( $phalanxTestTitle, wfMessage( 'userrenametool-see-list-of-blocks' )->escaped(), [], [ 'wpBlockText' => $text ] );
			$warning = wfMessage( 'userrenametool-warning-phalanx-block', $text )->rawParams( $linkToTest )->escaped();
		}

		wfProfileOut( __METHOD__ );

		return $warning;
	}

	static public function getLog( $message, $requestor, $oldUsername, $newUsername, $reason, $tasks = [] ) {
		foreach ( $tasks as $key => $value ) {
			$title = GlobalTitle::newFromText( 'Tasks/log', NS_SPECIAL, self::COMMUNITY_CENTRAL_CITY_ID );

			$tasks[$key] = Xml::element(
				'a',
				['href' => $title->getFullURL( ['id' => $value] )],
				"#{$value}",
				false
			);
		}

		return wfMessage(
			$message,
			User::getLinkToUserPageOnCommunityWiki( $requestor ),
			User::getLinkToUserPageOnCommunityWiki( $oldUsername, true ),
			User::getLinkToUserPageOnCommunityWiki( $newUsername ),
			$tasks ? implode( ', ', $tasks ) : '-',
			$reason
		)->escaped();
	}

	static public function getLogForWiki($requestor, $oldUsername, $newUsername, $cityId, $reason, $problems = false ) {
		$text = wfMessage(
			$problems ? 'userrenametool-info-wiki-finished-problems' : 'userrenametool-info-wiki-finished',
			User::getLinkToUserPageOnCommunityWiki( $requestor ),
			User::getLinkToUserPageOnCommunityWiki( $oldUsername, true ),
			User::getLinkToUserPageOnCommunityWiki( $newUsername ),
			WikiFactory::getCityLink( $cityId ),
			$reason
		)->escaped();

		return $text;
	}
}
