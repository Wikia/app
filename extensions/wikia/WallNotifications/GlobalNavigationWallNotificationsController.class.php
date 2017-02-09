<?php

/*
 * in here we render Notifications in top-right corner of Wikia interface
 */


class GlobalNavigationWallNotificationsController extends WallNotificationControllerBase {
	protected function addAssets() {
		$this->response->addAsset( 'extensions/wikia/GlobalNavigation/styles/GlobalNavigationNotifications.scss' );
		$this->response->addAsset( 'wall_notifications_global_navigation_js' );
	}

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
