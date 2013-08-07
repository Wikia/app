<?php
class WallNotificationEntity {

	/**
	 * @desc WallNotification id (it contains article_id and city_id concatenated)
	 * @var String $id
	 */
	public $id;

	/**
	 * @desc Data stored in memcache
	 * @var stdClass $data
	 */
	public $data;

	/**
	 * @desc This data is here only after you create this object when recreating object from memcache this will be empty
	 * @var stdClass $data_non_cached
	 */
	public $data_non_cached;

	/**
	 * @desc Creates instance of WallNotificationEntity, loads it data from given revision
	 *
	 * @param Revision $rev revision instance
	 * @param Integer $wikiId wiki id aka city_id
	 * @param bool $master flag if the data should be pulled from master; false by default
	 *
	 * @return WallNotificationEntity
	 */
	public static function createFromRev( Revision $rev, $wikiId, $master = false ) {
		$wn = new WallNotificationEntity();

		if( $wn->loadDataFromRev( $rev, $wikiId, $master ) ) {
			$wn->save();
		}

		return $wn;
	}

	public static function getByWikiAndRevId( $revId, $wikiId ) {
		return WallNotificationEntity::getById( $revId . '_' . $wikiId );
	}

	public static function getById( $id ) {
		$wn = new WallNotificationEntity();

		$wn->id = $id;
		$wn->data = $wn->getCache()->get( $wn->getMemcKey() );

		$wn->data = null;

		if( empty( $wn->data ) ) {
			$wn->recreateFromDB();
		}

		if( empty( $wn->data ) ) {
			return null;
		}

		return $wn;
	}

	public function isMain() {
		return empty( $this->data->parent_id );
	}

	public function getUniqueId() {
		if( $this->isMain() ) {
			return $this->data->title_id;
		} else {
			return $this->data->parent_id;
		}
	}

	public function getId() {
		return $this->id;
	}

	/**
	 * @desc Loads notification from specific cache mechanism and if no found there fetching it from database.
	 * Sets all needed fields to $data and $data_non_cached properties returns true when success
	 *
	 * @param Revision $rev instance of Revision connected to the article
	 * @param Integer $wikiId wiki id aka city_id
	 * @param bool $master flag if the data should be pulled from master; false by default
	 *
	 * @return bool
	 */
	public function loadDataFromRev( Revision $rev, $wikiId, $master = false ) {
		$this->id = $rev->getId(). '_' .  $wikiId;

		$ac = WallMessage::newFromTitle( $rev->getTitle() ); /* @var $ac WallMessage */
		$ac->load();

		$app = F::app();

		$this->data = new stdClass;
		$this->data_non_cached = new StdClass();

		$walluser = $ac->getWallOwner( $master );
		$authoruser = User::newFromId( $rev->getUser() );

		if( empty( $walluser ) ) {
			error_log( 'WALL_NO_OWNER: (entityId)' . $this->id );
			$this->data = null;
			$this->data_non_cached = null;

			return false;
		}

		$this->data->wiki = $wikiId;
		$this->data->wikiname = $app->wg->sitename;
		$this->data->rev_id = $rev->getId();

		$wallTitle = $ac->getWallTitle();
		if( !empty($wallTitle) && $wallTitle->exists() ) {
			$this->data->article_title_ns = $wallTitle->getNamespace();
			$this->data->article_title_text = $wallTitle->getText();
			$this->data->article_title_dbkey = $wallTitle->getDBkey();
			$this->data->article_title_id = $wallTitle->getArticleId();
		} else {
			$this->data->article_title_ns = null;
			$this->data->article_title_text = null;
			$this->data->article_title_dbkey = null;
			$this->data->article_title_id = null;
		}

		$this->data->timestamp = $rev->getTimestamp();
		$this->data->parent_id = null;
		$this->data->parent_page_id = $ac->getWallTitle()->getArticleId();

		if( $authoruser instanceof User ) {
			$this->data->msg_author_id = $authoruser->getId();
			$this->data->msg_author_username = $authoruser->getName();
			if( $authoruser->getId() > 0 ) {
				$this->data->msg_author_displayname = $this->data->msg_author_username;
			} else {
				$this->data->msg_author_displayname = wfMsg('oasis-anon-user');
			}
		} else {
		//annon
			$this->data->msg_author_displayname = wfMsg('oasis-anon-user');
			$this->data->msg_author_id = 0;
		}

		$this->data->wall_username = $walluser->getName();

		$this->data->wall_userid = $walluser->getId();
		$this->data->wall_displayname = $this->data->wall_username;
		//TODO: double ?
		$this->data->title_id = $ac->getTitle()->getArticleId();

		$this->data_non_cached->title = $ac->getTitle();

		/**
		 * @var WallMessage $acParent
		 */
		$acParent = $ac->getTopParentObj();
		$this->data->parent_username = '';
		$this->data->thread_title = '';
		$this->data_non_cached->parent_title_dbkey = '';

		$this->data_non_cached->msg_text = $ac->getText();
		$this->data->notifyeveryone = $ac->getNotifyeveryone();

		if( $ac->isEdited() ) {
			$this->data->reason = $ac->getLastEditSummery();
		} else {
			$this->data->reason = '';
		}

		if( !empty($acParent) ) {
			$acParent->load();
			$parentUser = $acParent->getUser();

			if( $parentUser instanceof User ) {
				$this->data->parent_username = $parentUser->getName();
				if($parentUser->getId() > 0) {
					$this->data->parent_displayname = $this->data->parent_username;
				} else {
					$this->data->parent_displayname = wfMsg('oasis-anon-user');
				}
				$this->data->parent_user_id = $acParent->getUser()->getId();
			} else {
			// parent was deleted and somehow reply stays in the system
			// the only way I've reproduced it was: I deleted a thread
			// then I went to Special:Log/delete and restored only its reply
			// an edge case but it needs to be handled
			// --nAndy
				$this->data->parent_username = $this->data->parent_displayname = wfMsg('oasis-anon-user');
				$this->data->parent_user_id = 0;
			}
			$title = $acParent->getTitle();
			$this->data_non_cached->thread_title_full = $acParent->getMetaTitle();
			$this->data->thread_title = $acParent->getMetaTitle();
			$this->data_non_cached->parent_title_dbkey = $title->getDBkey();
			$this->data->parent_id = $acParent->getId();
			$this->data->url = $ac->getMessagePageUrl();

		} else {
			$this->data->url = $ac->getMessagePageUrl();
			$this->data->parent_username = $walluser->getName();
			$this->data_non_cached->thread_title_full = $ac->getMetaTitle();
			$this->data->thread_title = $ac->getMetaTitle();
		}

		return true;
	}

	function recreateFromDB() {
		$explodedId = explode( '_', $this->id );
		$revId = $explodedId[0];
		$wikiId = $explodedId[1];

		$rev = Revision::newFromId( $revId );
		if( empty( $rev ) ) {
			// also cache failures not to make expensive database queries
			// again and again for the same Entity
			$this->save();
			return;
		}

		$this->loadDataFromRev( $rev, $wikiId );
		$this->save();
	}

	public function save() {
		$cache = $this->getCache();
		$key = $this->getMemcKey();
		$cache->set( $key, $this->data );
	}

	/**
	 * Helper functions
	 */
	public function getMemcKey() {
		return wfSharedMemcKey( __CLASS__, "v32", $this->id, 'notification' );
	}

	/**
	 * @return Memcache
	 */
	public function getCache() {
		global $wgMemc;
		return $wgMemc;
	}
}
