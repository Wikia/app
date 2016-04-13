<?php

/**
 * ChatUser is a model-like class that handles all the model responsibilities.
 *
 * No permissions checks are done here so any code using this class is responsible for access control.
 */
class ChatUser extends WikiaObject {

	// Cache ban info for 24h, 24*60*60 = 86400
	const BAN_INFO_TTL = 86400;

	// Value to store in memcache when no ban information is found
	const NO_BAN_MARKER = -1;

	private $user;
	private $wikiId;

	public function __construct( User $user, $wikiId = null ) {
		global $wgCityId;

		parent::__construct();

		if ( $user->isAnon() ) {
			throw new Exception( "Chat user must be a registered user" );
		}

		if ( $wikiId === null ) {
			$wikiId = $wgCityId;
		}

		$this->user = $user;
		$this->wikiId = $wikiId;
	}

	public function getUser() {
		return $this->user;
	}

	public function getId() {
		return $this->user->getId();
	}

	public function getName() {
		return $this->user->getName();
	}

	public function getWikiId() {
		return $this->wikiId;
	}

	public function ban( $adminId, $endOn, $reason ) {
		$dbw = wfGetDB( DB_MASTER, [ ], $this->wg->ExternalDatawareDB );

		$dbw->replace(
			'chat_ban_users',
			null,
			[
				'cbu_wiki_id' => $this->getWikiId(),
				'cbu_user_id' => $this->getId(),
				'cbu_admin_user_id' => $adminId,
				'start_date' => wfTimestamp( TS_MW ),
				'end_date' => wfTimestamp( TS_MW, $endOn ),
				'reason' => $reason
			],
			__METHOD__
		);

		$this->clearBanInfoCache();
	}

	public function unban() {
		$dbw = wfGetDB( DB_MASTER, [ ], $this->wg->ExternalDatawareDB );

		$dbw->delete(
			'chat_ban_users',
			[
				'cbu_wiki_id' => $this->getWikiId(),
				'cbu_user_id' => $this->getId(),
			],
			__METHOD__
		);

		$this->clearBanInfoCache();
	}

	/**
	 * Get information if user is banned
	 *
	 * @return bool
	 */
	public function isBanned() {
		return $this->getBanInfo() !== false;
	}

	/**
	 * Get (possibly cached) ban details. Returns false if not banned.
	 *
	 * @return stdClass|false
	 */
	public function getBanInfo() {
		$banInfo = $this->getBanInfoFromCache();
		if ( empty( $banInfo ) ) {
			$banInfo = $this->getBanInfoFromDb();

			$this->storeBanInfoInCache( $banInfo );
		}

		// check if ban has expired
		if ( $banInfo ) {
			$endDate = wfTimestamp( TS_UNIX, $banInfo->end_date );
			if ( $endDate < time() ) {
				$banInfo = false;
			}
		}

		return $banInfo;
	}

	private function getBanInfoFromCache() {
		$banInfo = $this->wg->Memc->get( $this->getBanInfoCacheKey() );
		if ( $banInfo === self::NO_BAN_MARKER ) {
			$banInfo = false;
		}

		return $banInfo;
	}

	private function storeBanInfoInCache( $banInfo ) {
		if ( empty( $banInfo ) ) {
			$banInfo = self::NO_BAN_MARKER;
		}

		$this->wg->Memc->set( $this->getBanInfoCacheKey(), $banInfo, self::BAN_INFO_TTL );
	}

	/**
	 * Get ban status from database slave
	 *
	 * @return stdClass|false
	 */
	private function getBanInfoFromDb() {
		$db = wfGetDB( DB_SLAVE, [ ], $this->wg->ExternalDatawareDB );

		$info = $db->selectRow(
			'chat_ban_users',
			[ 'cbu_wiki_id', 'cbu_user_id', 'cbu_admin_user_id', 'end_date', 'reason' ],
			[
				'cbu_wiki_id' => $this->getWikiId(),
				'cbu_user_id' => $this->getId(),
			],
			__METHOD__
		);

		return $info;
	}

	/**
	 * Clear cache for ban status
	 */
	public function clearBanInfoCache() {
		WikiaDataAccess::cachePurge( $this->getBanInfoCacheKey() );
	}

	/**
	 * Get ban status cache key
	 *
	 * @return string
	 */
	private function getBanInfoCacheKey() {
		// Using shared mem key, but adding in the WikiID ourselves since its possible
		// to call these functions with an alternate wiki ID.
		return wfSharedMemcKey( 'chat-baninfo-v2', $this->getWikiId(), $this->getId() );
	}

	public function blockUser( User $blockedUser, $doCommit = false ) {
		$dbw = wfGetDB( DB_MASTER, [ ], F::app()->wg->ExternalDatawareDB );

		$dbw->replace(
			"chat_blocked_users",
			null,
			[
				'cbu_user_id' => $this->getId(),
				'cbu_blocked_user_id' => $blockedUser->getId(),
			],
			__METHOD__
		);

		if ( $doCommit ) {
			$dbw->commit();
		}
	}

	public function unblockUser( User $blockedUser, $doCommit = false ) {
		$dbw = wfGetDB( DB_MASTER, [ ], F::app()->wg->ExternalDatawareDB );

		$dbw->delete(
			"chat_blocked_users",
			[
				'cbu_user_id' => $this->getId(),
				'cbu_blocked_user_id' => $blockedUser->getId(),
			],
			__METHOD__
		);

		if ( $doCommit ) {
			$dbw->commit();
		}
	}

	public function getBlockedUsers() {
		$dbr = wfGetDB( DB_SLAVE, [ ], $this->wg->ExternalDatawareDB );

		return $dbr->selectFieldValues(
			"chat_blocked_users",
			'cbu_blocked_user_id',
			[
				'cbu_user_id' => $this->getId()
			],
			__METHOD__
		);
	}

	public function getBlockedByUsers() {
		$dbr = wfGetDB( DB_SLAVE, [ ], $this->wg->ExternalDatawareDB );

		return $dbr->selectFieldValues(
			"chat_blocked_users",
			'cbu_user_id',
			[
				'cbu_blocked_user_id' => $this->getId()
			],
			__METHOD__
		);
	}

	public static function newFromId( $userId, $wikiId = null ) {
		return new self( User::newFromId( $userId ), $wikiId );
	}

	public static function newFromName( $userName, $wikiId = null ) {
		return new self( User::newFromName( $userName ), $wikiId );
	}

	public static function newCurrent() {
		global $wgUser;

		return self::newFromId( $wgUser->getId() );
	}

}