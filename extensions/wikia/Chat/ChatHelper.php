<?php

class ChatHelper {

	/**
	 * Hooks into GetRailModuleList and adds the chat module to the side-bar when appropriate.
	 */
	static public function onGetRailModuleList(&$modules) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		// Add module only for logged-in users
		if ($wgUser->isLoggedIn()) {
			$modules[1] = array('ChatRail', 'ChatEntry', null);
		}
		
		wfProfileOut(__METHOD__);
		return true;
	}
}
