<?php
class WikiNavigationService extends NavigationService {
	const WIKIA_GLOBAL_VARIABLE = 'wgOasisGlobalNavigation';
	const WIKI_LOCAL_MESSAGE = 'Wiki-navigation';
	const CACHE_TTL = 10800; // 3 hours

	public function parseMenu($menuName, Array $maxChildrenAtLevel, $filterInactiveSpecialPages = false){
		switch($menuName) {
			case self::WIKIA_GLOBAL_VARIABLE:
				// get menu content from WikiFactory variable
				return $this->parseVariable(
					$menuName,
					$maxChildrenAtLevel,
					self::CACHE_TTL,
					true /* $forContent */,
					$filterInactiveSpecialPages
				);
				break;

			case self::WIKI_LOCAL_MESSAGE:
			default:
				// get menu content from the message
				return $this->parseMessage(
					$menuName,
					$maxChildrenAtLevel,
					self::CACHE_TTL,
					true /* $forContent */,
					$filterInactiveSpecialPages
				);
		}
	}
}