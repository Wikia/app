<?php

/**
 * ChatUser is a model-like class that handles all the model responsibilities.
 *
 * No permissions checks are done here so any code using this class is responsible for access control.
 */
class ChatUser extends WikiaModel {

	// Cache ban info for 24h, 24*60*60 = 86400
	const BAN_INFO_TTL = 86400;

	// Value to store in memcache when no ban information is found
	const NO_BAN_MARKER = 'NO_BAN';

	private $user;
	private $wikiId;

	public function __construct( User $user, $wikiId = null ) {
		global $wgCityId;

		parent::__construct();

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

	public function isAnon() {
		return $this->user->isAnon();
	}

	public function getWikiId() {
		return $this->wikiId;
	}

	public function ban( $adminId, $endOn, $reason ) {
		if ( $this->isAnon() ) {
			throw new InvalidArgumentException( 'Cannot ban anonymous user' );
		}

		$this->getDatawareDB( DB_MASTER )->replace(
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
		if ( $this->isAnon() ) {
			throw new InvalidArgumentException( 'Cannot unban anonymous user' );
		}

		$this->getDatawareDB( DB_MASTER )->delete(
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
		if ( $this->isAnon() ) {
			return false;
		}

		return $this->getBanInfo() !== false;
	}

	/**
	 * Get (possibly cached) ban details. Returns false if not banned.
	 *
	 * @return stdClass|false
	 */
	public function getBanInfo() {
		if ( $this->isAnon() ) {
			return false;
		}

		$existedInCache = null;
		$banInfo = $this->getBanInfoFromCache( $existedInCache );

		if ( !$existedInCache ) {
			$banInfo = $this->getBanInfoFromDb();
		}

		$this->handleExpiration( $banInfo );

		if ( !$existedInCache ) {
			$this->storeBanInfoInCache( $banInfo );
		}

		return $banInfo;
	}

	private function getBanInfoFromCache( &$existed ) {
		$banInfo = $this->wg->Memc->get( $this->getBanInfoCacheKey() );
		$existed = !empty( $banInfo );

		return $banInfo === self::NO_BAN_MARKER ? false : $banInfo ;
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
		return $this->getDatawareDB()->selectRow(
			'chat_ban_users',
			[ 'cbu_wiki_id', 'cbu_user_id', 'cbu_admin_user_id', 'end_date', 'reason' ],
			[
				'cbu_wiki_id' => $this->getWikiId(),
				'cbu_user_id' => $this->getId(),
			],
			__METHOD__
		);
	}

	private function clearBanInfoCache() {
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
		return wfSharedMemcKey( 'chat-baninfo-v3', $this->getWikiId(), $this->getId() );
	}

	public function blockUser( User $blockedUser ) {
		if ( $this->isAnon() || $blockedUser->isAnon() ) {
			throw new InvalidArgumentException( 'Chat blocks work on registered users only' );
		}

		$this->getDatawareDB( DB_MASTER )->replace(
			"chat_blocked_users",
			null,
			[
				'cbu_user_id' => $this->getId(),
				'cbu_blocked_user_id' => $blockedUser->getId(),
			],
			__METHOD__
		);
	}

	public function unblockUser( User $blockedUser ) {
		if ( $this->isAnon() || $blockedUser->isAnon() ) {
			throw new InvalidArgumentException( 'Chat blocks work on registered users only' );
		}

		$this->getDatawareDB( DB_MASTER )->delete(
			"chat_blocked_users",
			[
				'cbu_user_id' => $this->getId(),
				'cbu_blocked_user_id' => $blockedUser->getId(),
			],
			__METHOD__
		);
	}

	public function getBlockedUsers() {
		if ( $this->isAnon() ) {
			throw new InvalidArgumentException( 'Chat blocks work on registered users only' );
		}

		return $this->getDatawareDB()->selectFieldValues(
			"chat_blocked_users",
			'cbu_blocked_user_id',
			[
				'cbu_user_id' => $this->getId()
			],
			__METHOD__
		);
	}

	public function getBlockedByUsers() {
		if ( $this->isAnon() ) {
			throw new InvalidArgumentException( 'Chat blocks work on registered users only' );
		}

		return $this->getDatawareDB()->selectFieldValues(
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

	private function handleExpiration( &$banInfo ) {
		if ( $banInfo ) {
			$endDate = wfTimestamp( TS_UNIX, $banInfo->end_date );
			if ( $endDate < time() ) {
				$banInfo = false;
			}
		}
	}

}
