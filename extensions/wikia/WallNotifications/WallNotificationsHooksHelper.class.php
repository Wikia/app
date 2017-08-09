<?php

class WallNotificationsHooksHelper {
	/**
	 * @brief Adds Wall Notifications script to Monobook pages
	 *
	 * @param Skin $skin
	 * @param string $text
	 * @return boolean
	 *
	 * @author Liz Lee
	 */
	static public function onSkinAfterBottomScripts( Skin $skin, string &$text ): bool {
		global $wgJsMimeType, $wgResourceBasePath, $wgExtensionsPath;

		if ( $skin->getUser()->isLoggedIn() && $skin->getSkinName() == 'monobook' ) {
			$text .= "<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/timeago/jquery.timeago.js\"></script>\n" .
				"<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WallNotifications/scripts/WallNotifications.js\"></script>\n";
		}

		return true;
	}

	/**
	 * @brief Add notification dropdown to right corner for monobook
	 *
	 * @param array $personalUrls
	 * @param Title $title
	 * @return true
	 *
	 * @author Tomasz Odrobny
	 * @author Piotrek Bablok
	 */
	static public function onPersonalUrls( array &$personalUrls, Title $title ) {
		global $wgUser, $wgEnableWallExt, $wgEnableForumExt, $wgOut;

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

				$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/WallNotifications/styles/monobook/WallNotificationsMonobook.scss' ) );
			}
		}

		return true;
	}


}
