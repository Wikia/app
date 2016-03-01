<?php

/*
 * in here we render Notifications in top-right corner of Wikia interface
 */


class GlobalNavigationWallNotificationsController extends WallNotificationControllerBase {

	const NOTIFICATION_TITLE_LIMIT = 48;

	private $wallHelper;

	public function __construct() {
		parent::__construct();
		$this->app = F::App();
	}

	public function Index() {
		wfProfileIn( __METHOD__ );
		parent::Index();
		wfProfileOut( __METHOD__ );
	}

	protected function addAssets() {
		$this->response->addAsset( 'extensions/wikia/GlobalNavigation/styles/GlobalNavigationNotifications.scss' );
		$this->response->addAsset( 'wall_notifications_global_navigation_js' );
	}

	public function updateExt( $notificationCounts ) {
		$this->response->setVal( 'wikiCount', count( $notificationCounts ) );
	}

	public function getTitle( $title ) {
		return $this->getWallHelper()->shortenText( $title, self::NOTIFICATION_TITLE_LIMIT );

	}

	protected function areNotificationsSuppressedByExtensions() {
		global $wgUser;

		$suppressed = !$wgUser->isAllowed( 'read' );
		return !empty( $suppressed );
	}

	protected function setUnread( $unread ) {
		$this->response->setVal( 'isUnread', $unread ? 'unread' : 'read' );
	}

	protected function setTemplate() {
		$this->response->getView()->setTemplate( 'GlobalNavigationWallNotificationsController', 'NotifyEveryone' );
	}

	private function getWallHelper() {
		if ( empty( $this->wallHelper ) ) {
			$this->wallHelper = new WallHelper();
		}

		return $this->wallHelper;
	}

}
