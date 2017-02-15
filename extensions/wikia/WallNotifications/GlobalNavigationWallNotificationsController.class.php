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

	protected function addAssets() {}

	protected function updateExt( $notificationCounts ) {
		$this->response->setVal( 'wikiCount', count( $notificationCounts ) );
	}

	protected function areNotificationsSuppressedByExtensions() {
		return !$this->getContext()->getUser()->isAllowed( 'read' );
	}

	protected function setUnread( $unread ) {
		$this->response->setVal( 'isUnread', $unread ? 'unread' : 'read' );
	}

	protected function setTemplate() {
		$this->response->getView()->setTemplate( 'GlobalNavigationWallNotificationsController', 'NotifyEveryone' );
	}
}
