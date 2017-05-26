<?php

class WallNotificationsHooksHelper {
	/**
	 * @brief Adds Wall Notifications script to Monobook pages
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return boolean
	 *
	 * @author Liz Lee
	 */
	static public function onBeforePageDisplay( OutputPage $out, Skin $skin ): bool {
		if ( $skin->getSkinName() === 'monobook' && $skin->getUser()->isLoggedIn() ) {
			$out->addModules( 'ext.wikia.wallNotifications.monoBook' );
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
	static public function onPersonalUrls( &$personalUrls, &$title ) {
		global $wgUser, $wgEnableWallExt, $wgEnableForumExt;

		if ( $wgUser instanceof User && $wgUser->isLoggedIn() ) {
			if ( $wgUser->getSkin()->getSkinName() == 'monobook' ) {
				$personalUrls['wall-notifications'] = [
						'text' => wfMessage( 'wall-notifications' )->text(),
						'href' => '#',
						'class' => 'wall-notifications-monobook ',
						'active' => false
				];

				/**
				 * none of the Wall "base" extension is enable so we are pre hide the notification drop down
				 * and we show it in java script when there are new notification
				 */

				if ( empty( $wgEnableWallExt ) && empty( $wgEnableForumExt ) ) {
					$personalUrls['wall-notifications']['class'] .= 'prehide';
				}
			}
		}

		return true;
	}


}
