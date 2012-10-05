<?php

class InWikiGameHelper {
	public function onGetRailModuleList(&$modules) {
		wfProfileIn(__METHOD__);

		$modules[1400] = array('InWikiGameRail', 'Index', null);

		wfProfileOut(__METHOD__);

		return true;
	}
}