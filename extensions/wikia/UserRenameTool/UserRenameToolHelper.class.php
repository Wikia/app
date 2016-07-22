<?php

class UserRenameToolHelper {
	const COMMUNITY_CENTRAL_CITY_ID = 177;

	public static function getCentralUserTable() {
		return F::app()->wg->ExternalSharedDB . '.user';
	}

	/**
	 * Gets wikis an IP address might have edits on
	 *
	 * @param String $ipAddress The IP address to lookup
	 * @return array
	 */
	public static function lookupIPActivity( $ipAddress ) {
		global $wgDevelEnvironment, $wgSpecialsDB;

		if ( empty( $ipAddress ) || !IP::isIPAddress( $ipAddress ) ) {
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

		return $result;
	}

	/**
	 * Performs a test of all available phalanx filters and returns warning message if there are any
	 *
	 * @param $text String to match
	 * @return String with HTML to display via AJAX
	 */
	public static function testBlock( $text ) {

		if ( !class_exists( 'PhalanxService' ) ) {
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

		return $warning;
	}

	static public function getLog( $message, $requestor, $oldUsername, $newUsername, $reason, $tasks = [] ) {
		foreach ( $tasks as $key => $value ) {
			$title = GlobalTitle::newFromText( 'Tasks/log', NS_SPECIAL, self::COMMUNITY_CENTRAL_CITY_ID );

			$tasks[$key] = Xml::element(
				'a',
				[ 'href' => $title->getFullURL( ['id' => $value] ) ],
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

	/**
	 * @param string $requestor
	 * @param string $oldUsername
	 * @param string $newUsername
	 * @param int $cityId
	 * @param string $reason
	 * @param bool $problems
	 *
	 * @return String
	 */
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
