<?php 

class WallNotificationsHooksHelper { 
	/**
	 * @brief Adds Wall Notifications script to Monobook pages
	 *
	 * @return true
	 *
	 * @author Liz Lee
	 */
	public function onSkinAfterBottomScripts($skin, $text) {
		$app = F::App();
		$user = $app->wg->User;

		if( $user instanceof User && $user->isLoggedIn() && $skin->getSkinName() == 'monobook') {
			$text .= "<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ResourceBasePath}/resources/wikia/libraries/jquery/timeago/jquery.timeago.js\"></script>\n" .
				"<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/Wall/js/WallNotifications.js\"></script>\n";
		}

		return true;
	}

	/**
	 * @brief pre render the notifications
	 *
	 **/

	public function onMakeGlobalVariablesScript( &$vars ){
		$user =	F::app()->wg->User;
		if( $user->isLoggedIn() ) {
			$response = F::app()->sendRequest( 'WallNotificationsExternalController', 'getUpdateCounts', array() );
			$vars['wgNotificationsCount'] = $response->getData();
		}
		return true;
	}
	
}