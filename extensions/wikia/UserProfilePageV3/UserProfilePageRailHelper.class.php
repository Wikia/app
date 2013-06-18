<?php

class UserProfilePageRailHelper {

	/**
	 * @brief Hooks into GetRailModuleList
	 *
	 * @return boolean true
	 */
	static public function onGetRailModuleList(&$modules) {
		global $UPPNamespaces;

		$wg = F::app()->wg;
		if ( !in_array( $wg->Title->getNamespace(), $UPPNamespaces ) ) {
			return true;
		}
		wfProfileIn(__METHOD__);

		$pageOwner = UserProfilePageHelper::getUserFromTitle();
		if( !$pageOwner->getOption('hidefollowedpages') && !$wg->Title->isSpecial('Following') && !$wg->Title->isSpecial('Contributions') ) {
			$modules[1101] = array('FollowedPages', 'Index', array('showDeletedPages' => false));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

}
