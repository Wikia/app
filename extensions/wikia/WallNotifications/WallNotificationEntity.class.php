<?php
class WallNotificationEntity extends NotificationEntityDecorator {
	/**
	 * @var BaseNotificationEntity $notificationEntity
	 */
	private $notificationEntity;

	public function __construct( $notificationEntity ) {
		$this->notificationEntity = $notificationEntity;
	}

	public function loadDataFromRev( Revision $rev, $wikiId, $master = false ) {
		$result = $this->notificationEntity->loadDataFromRev( $rev, $wikiId, $master );

		if( $result ) {
			$ac = WallMessage::newFromTitle( $rev->getTitle() ); /* @var $ac WallMessage */
			$ac->load();

			$walluser = $ac->getWallOwner( $master );
			if( empty( $walluser ) ) {
				error_log( 'WALL_NO_OWNER: (entityId)' . $this->notificationEntity->id );
				$this->notificationEntity->data = null;
				$this->notificationEntity->data_non_cached = null;

				return false;
			}

			$wallTitle = $ac->getWallTitle();
			$this->notificationEntity->data->parent_page_id = $wallTitle->getArticleId();
			if( !empty($wallTitle) && $wallTitle->exists() ) {
				$this->notificationEntity->data->article_title_ns = $wallTitle->getNamespace();
				$this->notificationEntity->data->article_title_text = $wallTitle->getText();
				$this->notificationEntity->data->article_title_dbkey = $wallTitle->getDBkey();
				$this->notificationEntity->data->article_title_id = $wallTitle->getArticleId();
			}

			$this->notificationEntity->data->wall_username = $walluser->getName();
			$this->notificationEntity->data->wall_userid = $walluser->getId();
			$this->notificationEntity->data->wall_displayname = $this->notificationEntity->data->wall_username;
			$this->notificationEntity->data->wall_username = $walluser->getName();
			$this->notificationEntity->data->wall_userid = $walluser->getId();
			$this->notificationEntity->data->wall_displayname = $this->notificationEntity->data->wall_username;

			/**
			 * @var WallMessage $acParent
			 */
			$acParent = $ac->getTopParentObj();
			$this->notificationEntity->data_non_cached->msg_text = $ac->getText();
			$this->notificationEntity->data->notifyeveryone = $ac->getNotifyeveryone();

			if( $ac->isEdited() ) {
				$this->notificationEntity->data->reason = $ac->getLastEditSummery();
			}

			if( !empty($acParent) ) {
				$acParent->load();
				$parentUser = $acParent->getUser();

				if( $parentUser instanceof User ) {
					$this->notificationEntity->data->parent_username = $parentUser->getName();
					if($parentUser->getId() > 0) {
						$this->notificationEntity->data->parent_displayname = $this->notificationEntity->data->parent_username;
					} else {
						$this->notificationEntity->data->parent_displayname = wfMsg('oasis-anon-user');
					}
					$this->notificationEntity->data->parent_user_id = $acParent->getUser()->getId();
				} else {
					// parent was deleted and somehow reply stays in the system
					// the only way I've reproduced it was: I deleted a thread
					// then I went to Special:Log/delete and restored only its reply
					// an edge case but it needs to be handled
					// --nAndy
					$this->notificationEntity->data->parent_username = $this->notificationEntity->data->parent_displayname = wfMsg('oasis-anon-user');
					$this->notificationEntity->data->parent_user_id = 0;
				}
				$title = $acParent->getTitle();
				$this->notificationEntity->data_non_cached->thread_title_full = $acParent->getMetaTitle();
				$this->notificationEntity->data->thread_title = $acParent->getMetaTitle();
				$this->notificationEntity->data_non_cached->parent_title_dbkey = $title->getDBkey();
				$this->notificationEntity->data->parent_id = $acParent->getId();
				$this->notificationEntity->data->url = $ac->getMessagePageUrl();

			} else {
				$this->notificationEntity->data->url = $ac->getMessagePageUrl();
				$this->notificationEntity->data->parent_username = $walluser->getName();
				$this->notificationEntity->data_non_cached->thread_title_full = $ac->getMetaTitle();
				$this->notificationEntity->data->thread_title = $ac->getMetaTitle();
			}
		}

		return $result;
	}

}
