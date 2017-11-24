<?php
class StaffLogger {
	static public function log(string $type, string $action, int $userId, string $userName, int $userdstId, string $userNamedst, $comment = "") {
		global $wgSitename,$wgCityId,$wgExternalDatawareDB;
		$dbw =  wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
		$now = wfTimestampNow();
		$data = array(
			'slog_type' => $type,
			'slog_action' => $action,
			'slog_timestamp' => $dbw->timestamp( $now ),
			'slog_user' => $userId,
			'slog_user_namedst' => $userNamedst,
			'slog_user_name' =>  $userName,
			'slog_userdst' => $userdstId,
			'slog_comment' => $comment,
			'slog_site' => $wgSitename,
			'slog_city' => $wgCityId
		);
		$dbw->insert( 'wikiastaff_log', $data, __METHOD__ );
	}

	static public function setupStafflog() {
		global $wgHooks;
		$wgHooks['BlockIpStaffPowersCancel'][] = 'StaffLogger::eventlogBlockIp';
		$wgHooks['PiggybackLogOut'][] = 'StaffLogger::eventlogPiggybackLogOut';
		$wgHooks['PiggybackLogIn'][] = 'StaffLogger::eventlogPiggybackLogIn';
		$wgHooks['WikiFactoryPublicStatusChange'][] = 'StaffLogger::eventlogWFPublicStatusChange';
	}

	/**
	 * @static
	 * @param User $user
	 * @param User $userdst
	 * @return bool
	 */
	static public function eventlogPiggybackLogIn($user, $userdst) {
		self::log("piggyback", "login", $user->getID(), $user->getName(), $userdst->getID(), $userdst->getName());
		return true;
	}

	/**
	 * @static
	 * @param User $user
	 * @param User $userdst
	 * @return bool
	 */
	static public function eventlogPiggybackLogOut($user, $userdst) {
		self::log("piggyback", "logout", $user->getID(), $user->getName(), $userdst->getID(), $userdst->getName());
		return true;
	}

	/**
	 * @static
	 * @param Block $block instance of Block class includes/Block.php
	 * @param User $user instance of User class includes/User.php
	 * @return bool true 'cause it's a hook
	 */
	static public function  eventlogBlockIp( $block, $user ) {
		self::log("block", "block", $user->getID(), $user->getName(), $block->getBlocker(), $block->getTarget(), $block->mReason);
		return true;
	}

	static private function getCommunityUser( string $name, $noRedirect = false ) :string {
		$title = GlobalTitle::newFromText( $name, NS_USER, COMMUNITY_CENTRAL_CITY_ID );
		return Xml::element( 'a', [ 'href' => $title->getFullURL(
			$noRedirect ? 'redirect=no' : ''
		) ], $name, false );
	}

	static private function getCityLink( int $cityId ) :string {
		global $wgCityId, $wgSitename;
		$domains = WikiFactory::getDomains( $cityId );
		if ( $wgCityId == $cityId ) {
			// Hack based on the fact we should only ask for current wiki's sitename
			$text = $wgSitename;
		} else {
			// The fallback to return anything
			$text = "[" . WikiFactory::IDtoDB( $cityId ) . ":{$cityId}]";
		}
		if ( !empty( $domains ) ) {
			$text = Xml::tags( 'a', [ "href" => "http://" . $domains[0] ], $text );
		}
		return $text;
	}

	static public function eventlogWFPublicStatusChange( $cityStatus, $cityId, $reason ) {
		global $wgUser;
		$comment = wfMessage(
			'stafflog-wiki-status-change',
			self::getCommunityUser( $wgUser->getName() ),
			self::getCityLink( $cityId ),
			$cityStatus,
			$reason
		)->inLanguage( 'en' )->text();
		// sadly, $type and $action have 10-character limit, hence 'wikifactor' and 'pubstatus'.
		self::log( 'wikifactor', 'pubstatus', $wgUser->getID(), $wgUser->getName(), 0, '',  $comment );
		return true;
	}
}
StaffLogger::setupStafflog();
