<?php
class NewbieExRailHelper {
	public function onGetRailModuleList(&$modules) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		if ( $wgUser->isLoggedIn() ) {
			$modules[1400] = array('NewbieExRail', 'Index', null);
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}
