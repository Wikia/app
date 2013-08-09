<?php

class BaseNotificationEntity {

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
		$wn = new self();

		if( $wn->loadDataFromRev( $rev, $wikiId, $master ) ) {
			$wn->save();
		}

		return $wn;
	}

	public static function getByWikiAndRevId( $revId, $wikiId ) {
		return static::getById( $revId . '_' . $wikiId );
	}

	public static function getById( $id ) {
		$wn = new BaseNotificationEntity();

		$wn->id = $id;
		$wn->data = $wn->getCache()->get( $wn->getMemcKey() );
		if( empty( $wn->data ) ) {
			$wn->recreateFromDB();
		}

		if( empty( $wn->data ) ) {
			return null;
		}

		return $wn;
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
		$app = F::app();

		$this->id = $rev->getId(). '_' .  $wikiId;

		$this->data = new stdClass;
		$this->data_non_cached = new StdClass();

		$this->data->article_title_ns = null;
		$this->data->article_title_text = null;
		$this->data->article_title_dbkey = null;
		$this->data->article_title_id = null;

		$this->data->wiki = $wikiId;
		$this->data->wikiname = $app->wg->sitename;
		$this->data->rev_id = $rev->getId();

		$this->data->timestamp = $rev->getTimestamp();
		$this->data->parent_id = null;

		/** @var User $authoruser */
		$authoruser = User::newFromId( $rev->getUser() );
		if( $authoruser instanceof User ) {
			$this->data->msg_author_id = $authoruser->getId();
			$this->data->msg_author_username = $authoruser->getName();
			if( $authoruser->getId() > 0 ) {
				$this->data->msg_author_displayname = $this->data->msg_author_username;
			} else {
				$this->data->msg_author_displayname = wfMsg('oasis-anon-user');
			}
		} else {
		// annon
			$this->data->msg_author_displayname = wfMsg('oasis-anon-user');
			$this->data->msg_author_id = 0;
		}

		$title = $rev->getTitle( $master );
		if( !empty($title) && $title->exists() ) {
			$articleId = $title->getArticleId();
			$this->data->parent_page_id = $articleId;

			$this->data->article_title_ns = $title->getNamespace();
			$this->data->article_title_text = $title->getText();
			$this->data->article_title_dbkey = $title->getDBkey();
			$this->data->article_title_id = $articleId;

			$this->data->title_id = $articleId;
			$this->data_non_cached->title = $title;
		}

		$this->data->parent_username = '';
		$this->data->thread_title = '';
		$this->data_non_cached->parent_title_dbkey = '';
		$this->data->reason = '';

		return true;
	}

	public function recreateFromDB() {
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

	public function getId() {
		return $this->id;
	}

	public function getUniqueId() {
		if( $this->isMain() ) {
			return $this->data->title_id;
		} else {
			return $this->data->parent_id;
		}
	}

	public function isMain() {
		return empty( $this->data->parent_id );
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
