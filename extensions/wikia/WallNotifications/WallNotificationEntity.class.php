<?php

use Wikia\Logger\WikiaLogger;

class WallNotificationEntity {
	/** @var int */
	public $id;

	/** @var stdClass data stored in memcache */
	public $data = null;

	public $parentTitleDbKey = '';
	public $msgText = '';
	public $threadTitleFull = '';

	/*
	 *	Public Interface
	 */

	/**
	 * Create a new object from an existing revision object.
	 *
	 * @param Revision $rev A revision object
	 * @param bool $useMasterDB Whether to query the MASTER DB on Title lookup.
	 *
	 * @return WallNotificationEntity|null
	 */
	public static function createFromRev( Revision $rev, $useMasterDB = false ) {
		$wn = new WallNotificationEntity();

		if ( $wn->loadDataFromRev( $rev, $useMasterDB ) ) {
			$wn->saveToCache();
			return $wn;
		}

		return null;
	}

	/**
	 * Create a new object from a Revision ID and a wikia ID.  If the wikia ID does not
	 * match the current wikia, this will make an external call to the wikia that
	 * owns the data.
	 *
	 * @param int $revId The revision ID for this notification entity
	 * @param int $wikiId The wiki where this revision exists
	 * @param bool $useMasterDB Whether to query the MASTER DB on Title lookup.
	 *
	 * @return WallNotificationEntity|null
	 */
	public static function createFromRevId( $revId, $wikiId, $useMasterDB = false ) {
		$wn = new WallNotificationEntity();

		if ( $wikiId == F::app()->wg->CityId ) {
			$success = $wn->loadDataFromRevId( $revId, $useMasterDB );
		} else {
			$success = $wn->loadDataFromRevIdOnWiki( $revId, $wikiId, $useMasterDB );
		}

		if ( $success ) {
			$wn->saveToCache();
			return $wn;
		}

		return null;
	}

	/**
	 * Create a new object from an entity ID.
	 *
	 * @param int $entityId An entity ID
	 * @param bool $useMasterDB Whether to query the MASTER DB on Title lookup.
	 *
	 * @return WallNotificationEntity|null
	 */
	public static function createFromId( $entityId, $useMasterDB = false ) {
		list( $revId, $wikiId ) = explode( '_', $entityId );

		return self::createFromRevId( $revId, $wikiId, $useMasterDB );
	}

	/**
	 * This method attempts to load data from the cache first before
	 *
	 * @param int $id
	 *
	 * @return WallNotificationEntity
	 */
	public static function getById( $id ) {
		$key = self::getMemcKey( $id );
		$data = F::app()->wg->Memc->get( $key );

		if ( empty( $data ) ) {
			return self::createFromId( $id );
		} else {
			$wn = new WallNotificationEntity();
			$wn->id = $id;
			$wn->data = $data;

			return $wn;
		}
	}

	/**
	 * Returns true if this entity represents a forum topic and false if it represents
	 * a comment to a topic
	 *
	 * @return bool
	 */
	public function isMain() {
		return empty( $this->data->parent_id );
	}

	/**
	 * Tests whether this is a notification for a reply to a thread topic.
	 *
	 * @return bool True if the message is a *reply* to a thread topic, false if it is a new thread topic
	 */
	public function isReply() {
		return !$this->isMain();
	}

	public function getUniqueId() {
		if ( $this->isMain() ) {
			return $this->data->title_id;
		} else {
			return $this->data->parent_id;
		}
	}

	/**
	 * This method calls out to the wiki given by $wikiId to get revision data, since
	 * this data cannot be gathered locally if $wikiId != $wgCityId
	 *
	 * @param int $revId
	 * @param int $wikiId
	 * @param bool $useMasterDB
	 * @return bool
	 */
	public function loadDataFromRevIdOnWiki( $revId, $wikiId, $useMasterDB = false ) {
		$dbName = WikiFactory::IDtoDB( $wikiId );
		$params = [
			'controller' => 'WallNotifications',
			'method' => 'getEntityData',
			'revId' => $revId,
			'useMasterDB' => $useMasterDB,
		];

		$response = ApiService::foreignCall( $dbName, $params, ApiService::WIKIA, /* loginAsUser */ true );
		if ( !empty( $response['status'] ) && $response['status'] == 'ok' ) {
			$this->parentTitleDbKey = $response['parentTitleDbKey'];
			$this->msgText = $response['msgText'];
			$this->threadTitleFull = $response['threadTitleFull'];
			$this->data = $response['data'];

			return true;
		}

		return false;
	}

	/**
	 * @param int $revId
	 * @param bool $userMasterDB
	 *
	 * @return bool
	 */
	public function loadDataFromRevId( $revId, $userMasterDB = false ) {
		$rev = Revision::newFromId( $revId );
		if ( empty( $rev ) ) {
			return false;
		}

		return $this->loadDataFromRev( $rev, $userMasterDB );
	}

	/**
	 * @param Revision $rev
	 * @param bool $useMasterDB
	 *
	 * @return bool
	 */
	public function loadDataFromRev( Revision $rev, $useMasterDB = false ) {
		// Reset any existing info stored in $this->data and start collecting in a new $data var
		$this->data = null;

		$data = new StdClass();
		$data->wiki = F::app()->wg->CityId;
		$data->wikiname = F::app()->wg->Sitename;

		$this->setMessageAuthorData( $data, $rev->getUser() );
		$data->rev_id = $rev->getId();
		$this->id = $data->rev_id . '_' .  $data->wiki;
		$data->timestamp = $rev->getTimestamp();

		// Set all data related to the WallMessage
		$wm = $this->getWallMessageFromRev( $rev );

		if ( !$this->setWallUserData( $data, $wm, $useMasterDB ) ) {
			return false;
		}
		$this->setArticleTitleData( $data, $wm );

		$this->msgText = $wm->getText();
		$data->title_id = $wm->getTitle()->getArticleId();
		$data->url = $wm->getMessagePageUrl();

		$data->notifyeveryone = $wm->getNotifyeveryone();
		$data->reason = $wm->isEdited() ? $wm->getLastEditSummary() : '';

		$this->setMessageParentData( $data, $wm );

		$this->data = $data;

		return true;
	}

	/**
	 * Loads a new WallMessage object from a Revision object
	 *
	 * @param Revision $rev
	 *
	 * @return WallMessage
	 */
	public function getWallMessageFromRev( Revision $rev ) {
		$wm = WallMessage::newFromTitle( $rev->getTitle() );
		$wm->load();

		return $wm;
	}

	private function setWallUserData( stdClass $data, WallMessage $wm, $useMasterDB ) {
		$wallUser = $wm->getWallOwner( $useMasterDB );

		if ( empty( $wallUser ) ) {
			WikiaLogger::instance()->error( 'Wall owner not found', [
				'method' => __METHOD__,
				'notificationEntityId' => $this->id,
			] );

			return false;
		}

		$data->wall_username = $wallUser->getName();
		$data->wall_userid = $wallUser->getId();
		$data->wall_displayname = $data->wall_username;

		return true;
	}

	private function setArticleTitleData( stdClass $data, WallMessage $wm ) {
		$wallTitle = $wm->getArticleTitle();
		if ( !empty( $wallTitle ) && $wallTitle->exists() ) {
			$data->article_title_ns = $wallTitle->getNamespace();
			$data->article_title_text = $wallTitle->getText();
			$data->article_title_dbkey = $wallTitle->getDBkey();
			$data->article_title_id = $wallTitle->getArticleId();

			$data->parent_page_id = $data->article_title_id;
		} else {
			$data->article_title_ns = null;
			$data->article_title_text = null;
			$data->article_title_dbkey = null;
			$data->article_title_id = null;

			$data->parent_page_id = null;
		}
	}

	private function setMessageAuthorData( stdClass $data, $userId ) {
		$authorName = $this->getUserName( $userId );

		// This knowingly may be null, an anonymous user's IP or a real users username
		$data->msg_author_username = $authorName;

		// If we're missing either of these, treat as an anonymous user
		if ( empty( $authorName ) || empty( $userId ) ) {
			$data->msg_author_id = 0;
			$data->msg_author_displayname = wfMessage( 'oasis-anon-user' )->escaped();
		} else {
			$data->msg_author_id = $userId;
			$data->msg_author_displayname = $data->msg_author_username;
		}
	}

	/**
	 * This method returns a user object given a user ID.
	 *
	 * @param int $userId User ID for the author of this post
	 *
	 * @return User|null
	 */
	public function getUserName( $userId ) {
		$user = User::newFromId( $userId );
		if ( $user instanceof User ) {
			return $user->getName();
		} else {
			return null;
		}
	}

	private function setMessageParentData( $data, WallMessage $wm ) {
		$acParent = $wm->getTopParentObj();

		if ( empty( $acParent ) ) {
			$this->threadTitleFull = $wm->getMetaTitle();

			$data->parent_id = null;
			$data->thread_title = $this->threadTitleFull;
			$data->parent_username = $data->wall_username;
		} else {
			$acParent->load();
			$title = $acParent->getTitle();
			$this->parentTitleDbKey = $title->getDBkey();
			$this->threadTitleFull = $acParent->getMetaTitle();

			$this->setMessageParentUserData( $data, $acParent );
			$data->parent_id = $acParent->getId();
			$data->thread_title = $this->threadTitleFull;
		}
	}

	private function setMessageParentUserData( stdClass $data, WallMessage $parent ) {
		$parentUser = $parent->getUser();

		if ( $parentUser instanceof User ) {
			$data->parent_username = $parentUser->getName();
			$data->parent_user_id = $parentUser->getId();

			if ( $data->parent_user_id > 0 ) {
				$data->parent_displayname = $data->parent_username;
			} else {
				$data->parent_displayname = wfMessage( 'oasis-anon-user' )->escaped();
			}
		} else {
			/* parent was deleted and somehow reply stays in the system
			 * the only way I've reproduced it was: I deleted a thread
			 * then I went to Special:Log/delete and restored only its reply
			 * an edge case but it needs to be handled
			 * --nAndy
			 */
			$data->parent_username = wfMessage( 'oasis-anon-user' )->escaped();
			$data->parent_displayname = $data->parent_username;
			$data->parent_user_id = 0;
		}
	}

	public function saveToCache() {
		$cache = F::app()->wg->Memc;
		$key = self::getMemcKey( $this->id );

		$cache->set( $key, $this->data );
	}

	public static function getMemcKey( $id ) {
		return wfSharedMemcKey( __CLASS__, "v32", $id, 'notification' );
	}
}
