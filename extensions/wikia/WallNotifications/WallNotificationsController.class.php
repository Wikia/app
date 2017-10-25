<?php

/**
 * Class WallNotificationsController
 *
 * Render Notifications in top-right corner of Wikia interface
 */
class WallNotificationsController extends WallNotificationControllerBase {
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
}
