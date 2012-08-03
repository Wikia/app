<?php

class ChatHelper {

	/**
	 * Hooks into GetRailModuleList and adds the chat module to the side-bar when appropriate.
	 */
	static public function onGetRailModuleList(&$modules) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		// Above spotlights, below everything else. BugzId: 4597.
		$modules[1175] = array('ChatRail', 'Placeholder', null);

		wfProfileOut(__METHOD__);
		return true;
	}
}
