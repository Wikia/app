<?php
class WallNotificationEntity extends BaseNotificationEntity {
	/**
	 * @var BaseNotificationEntity $notificationEntity
	 */
	private $notificationEntity;

	public function __construct( $notificationEntity ) {
		$this->notificationEntity = $notificationEntity;
	}

	public static function getById( $id ) {
		$wn = new self( new BaseNotificationEntity() );

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

	public static function createFromRev( Revision $rev, $wikiId, $master = false ) {
		$wn = new self( new BaseNotificationEntity() );

		if( $wn->loadDataFromRev( $rev, $wikiId, $master ) ) {
			$wn->save();
		}

		return $wn;
	}

	public function loadDataFromRev( Revision $rev, $wikiId, $master = false ) {
		$result = $this->notificationEntity->loadDataFromRev( $rev, $wikiId, $master );

		if( $result ) {
			$this->id = $this->notificationEntity->id;
			$this->data = $this->notificationEntity->data;
			$this->data_non_cached = $this->notificationEntity->data_non_cached;

			$ac = WallMessage::newFromTitle( $rev->getTitle() ); /* @var $ac WallMessage */
			$ac->load();

			$walluser = $ac->getWallOwner( $master );
			if( empty( $walluser ) ) {
				error_log( 'WALL_NO_OWNER: (entityId)' . $this->notificationEntity->id );
				$this->data = null;
				$this->data_non_cached = null;

				return false;
			}

			$wallTitle = $ac->getWallTitle();
			$this->data->parent_page_id = $wallTitle->getArticleId();
			if( !empty($wallTitle) && $wallTitle->exists() ) {
				$this->data->article_title_ns = $wallTitle->getNamespace();
				$this->data->article_title_text = $wallTitle->getText();
				$this->data->article_title_dbkey = $wallTitle->getDBkey();
				$this->data->article_title_id = $wallTitle->getArticleId();
			}

			$this->data->wall_username = $walluser->getName();
			$this->data->wall_userid = $walluser->getId();
			$this->data->wall_displayname = $this->data->wall_username;
			$this->data->wall_username = $walluser->getName();
			$this->data->wall_userid = $walluser->getId();
			$this->data->wall_displayname = $this->data->wall_username;

			/**
			 * @var WallMessage $acParent
			 */
			$acParent = $ac->getTopParentObj();
			$this->data_non_cached->msg_text = $ac->getText();
			$this->data->notifyeveryone = $ac->getNotifyeveryone();

			if( $ac->isEdited() ) {
				$this->data->reason = $ac->getLastEditSummery();
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
		}

		return $result;
	}

}
