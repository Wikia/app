<?php

class WallNotificationsHooksHelper {
	/**
	 * @brief Adds Wall Notifications script to Monobook pages
	 *
	 * @return boolean
	 *
	 * @author Liz Lee
	 */
	static public function onSkinAfterBottomScripts(Skin $skin, &$text) {
		$app = F::App();
		$user = $app->wg->User;

		if( $user instanceof User && $user->isLoggedIn() && $skin->getSkinName() == 'monobook') {
			$text .= "<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ResourceBasePath}/resources/wikia/libraries/jquery/timeago/jquery.timeago.js\"></script>\n" .
				"<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/WallNotifications/js/WallNotifications.js\"></script>\n";
		}

		return true;
	}

	/**
	 * @brief pre render the notifications
	 *
	 **/

	static public function onMakeGlobalVariablesScript( Array &$vars ){
		$user =	F::app()->wg->User;
		if( $user->isLoggedIn() ) {
			$response = F::app()->sendRequest( 'WallNotificationsExternalController', 'getUpdateCounts', array() );
			$vars['wgNotificationsCount'] = $response->getData();
		}
		return true;
	}


	/**
	 * @brief Add notification dropdown to right corner for monobook
	 *
	 * @return true
	 *
	 * @author Tomasz Odrobny
	 * @author Piotrek Bablok
	 */
	static public function onPersonalUrls(&$personalUrls, &$title) {
		$app = F::App();
		$user = $app->wg->User;
		if( $user instanceof User && $user->isLoggedIn() ) {
			if($app->wg->User->getSkin()->getSkinName() == 'monobook') {
				$personalUrls['wall-notifications'] = array(
						'text'=>wfMsg('wall-notifications'),
						//'text'=>print_r($app->wg->User->getSkin(),1),
						'href'=>'#',
						'class'=>'wall-notifications-monobook ',
						'active'=>false
				);

				/**
				 * none of the Wall "base" extension is enable so we are pre hide the notification drop down
				 * and we show it in java script when there are new notification
				 */

				if(empty($app->wg->EnableWallExt) && empty($app->wg->EnableForumExt)) {
					$personalUrls['wall-notifications']['class'] .= 'prehide';
				}

				$app->wg->Out->addStyle("{$app->wg->ExtensionsPath}/wikia/WallNotifications/css/WallNotificationsMonobook.css");
			}
		}

		return true;
	}

	static public function onNotificationAfterLoadDataFromRev( $id, &$data, &$data_non_cached, Revision $rev, $master ) {
		$ac = WallMessage::newFromTitle( $rev->getTitle() ); /* @var $ac WallMessage */
		$ac->load();

		$walluser = $ac->getWallOwner( $master );
		if( empty( $walluser ) ) {
			error_log( 'WALL_NO_OWNER: (entityId)' . $id );
			$data = null;
			$data_non_cached = null;

			return false;
		}

		$wallTitle = $ac->getWallTitle();
		$data->parent_page_id = $wallTitle->getArticleId();
		if( !empty($wallTitle) && $wallTitle->exists() ) {
			$data->article_title_ns = $wallTitle->getNamespace();
			$data->article_title_text = $wallTitle->getText();
			$data->article_title_dbkey = $wallTitle->getDBkey();
			$data->article_title_id = $wallTitle->getArticleId();
		}

		$data->wall_username = $walluser->getName();
		$data->wall_userid = $walluser->getId();
		$data->wall_displayname = $data->wall_username;
		$data->wall_username = $walluser->getName();
		$data->wall_userid = $walluser->getId();
		$data->wall_displayname = $data->wall_username;

		/**
		 * @var WallMessage $acParent
		 */
		$acParent = $ac->getTopParentObj();
		$data_non_cached->msg_text = $ac->getText();
		$data->notifyeveryone = $ac->getNotifyeveryone();

		if( $ac->isEdited() ) {
			$data->reason = $ac->getLastEditSummery();
		}

		if( !empty($acParent) ) {
			$acParent->load();
			$parentUser = $acParent->getUser();

			if( $parentUser instanceof User ) {
				$data->parent_username = $parentUser->getName();
				if($parentUser->getId() > 0) {
					$data->parent_displayname = $data->parent_username;
				} else {
					$data->parent_displayname = wfMsg('oasis-anon-user');
				}
				$data->parent_user_id = $acParent->getUser()->getId();
			} else {
				// parent was deleted and somehow reply stays in the system
				// the only way I've reproduced it was: I deleted a thread
				// then I went to Special:Log/delete and restored only its reply
				// an edge case but it needs to be handled
				// --nAndy
				$data->parent_username = $data->parent_displayname = wfMsg('oasis-anon-user');
				$data->parent_user_id = 0;
			}
			$title = $acParent->getTitle();
			$data_non_cached->thread_title_full = $acParent->getMetaTitle();
			$data->thread_title = $acParent->getMetaTitle();
			$data_non_cached->parent_title_dbkey = $title->getDBkey();
			$data->parent_id = $acParent->getId();
			$data->url = $ac->getMessagePageUrl();

		} else {
			$data->url = $ac->getMessagePageUrl();
			$data->parent_username = $walluser->getName();
			$data_non_cached->thread_title_full = $ac->getMetaTitle();
			$data->thread_title = $ac->getMetaTitle();
		}

		return true;
	}

}
