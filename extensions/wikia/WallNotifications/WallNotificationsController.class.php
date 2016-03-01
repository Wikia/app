<?php

/**
 * Class WallNotificationsController
 *
 * Render Notifications in top-right corner of Wikia interface
 */
class WallNotificationsController extends WallNotificationControllerBase {

	const NOTIFICATION_TITLE_LIMIT = 48;

	public function Index() {
		wfProfileIn( __METHOD__ );
		parent::Index();
		$this->response->setVal( 'suppressWallNotifications', $this->areNotificationsSuppressedByExtensions() );
		wfProfileOut( __METHOD__ );
	}

	protected function addAssets() {
		OasisController::addSkinAssetGroup( 'wall_notifications_js' );
		$this->response->addAsset( 'extensions/wikia/WallNotifications/styles/WallNotifications.scss' );
	}

	/**
	 * @param $notificationCounts
	 */
	protected function updateExt( $notificationCounts ) {
		// nothing to do in this controller
	}

	public function getTitle( $title ) {
		return $title;
	}

	protected function areNotificationsSuppressedByExtensions() {
		global $wgUser, $wgAtCreateNewWikiPage;

		$suppressed = $wgAtCreateNewWikiPage || !$wgUser->isAllowed( 'read' );
		return !empty( $suppressed );
	}

	protected function setUnread( $unread ) {
		// nothing to do in this controller
	}

	protected function setTemplate() {
		$this->response->getView()->setTemplate( 'WallNotificationsController', 'NotifyEveryone' );
	}

	public function getEntityData() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$revId = $this->getVal( 'revId' );
		$useMasterDB = $this->getVal( 'useMasterDB', false );

		$wn = new WallNotificationEntity();
		if ( $wn->loadDataFromRevId( $revId, $useMasterDB ) ) {
			$this->response->setData( [
				'data' => $wn->data,
				'parentTitleDbKey' => $wn->parentTitleDbKey,
				'msgText' => $wn->msgText,
				'threadTitleFull' => $wn->threadTitleFull,
				'status' => 'ok',
			] );
		} else {
			$this->response->setData( [
				'status' => 'error'
			] );
		}
	}
}
