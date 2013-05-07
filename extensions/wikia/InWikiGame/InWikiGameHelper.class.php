<?php
/**
 * InWikiGame extension helper
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class InWikiGameHelper {

	/**
	 * @param Array $modules right rail modules array
	 * @return bool return true because it's a hook
	 */
	static public function onGetRailModuleList(&$modules) {
		wfProfileIn(__METHOD__);

		$modules[1400] = array('InWikiGameRail', 'Index', null);

		wfProfileOut(__METHOD__);
		return true;
	}

}