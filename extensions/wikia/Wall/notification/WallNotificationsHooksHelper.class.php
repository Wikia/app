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
				"<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/Wall/js/WallNotifications.js\"></script>\n";
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
				
				$app->wg->Out->addStyle("{$app->wg->ExtensionsPath}/wikia/Wall/css/WallNotificationsMonobook.css");
			}
		}

		return true;
	}
	

}
