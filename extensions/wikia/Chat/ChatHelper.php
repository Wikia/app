<?php

class ChatHelper {

	/**
	 * Hooks into GetRailModuleList and adds the chat module to the side-bar when appropriate.
	 */
	static public function onGetRailModuleList(&$modules) {
		wfProfileIn(__METHOD__);

		$modules[1] = array('ChatRail', 'ButtonToOpenChat', null);

		wfProfileOut(__METHOD__);
		return true;
	}
}
