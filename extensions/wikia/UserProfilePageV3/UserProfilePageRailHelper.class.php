<?php

class UserProfilePageRailHelper {

	/**
	 * @brief Hooks into GetRailModuleList
	 *
	 * @return boolean true
	 */
	static public function onGetRailModuleList(&$modules) {
		global $wgTitle, $UPPNamespaces;
		if ( !in_array( $wgTitle->getNamespace(), $UPPNamespaces ) ) {
			return true;
		}
		wfProfileIn(__METHOD__);

		$pageOwner = UserProfilePageHelper::getUserFromTitle();
		if( !$pageOwner->getOption('hidefollowedpages') && !$wgTitle->isSpecial('Following') && !$wgTitle->isSpecial('Contributions') ) {
			$modules[1101] = array('FollowedPages', 'Index', array('showDeletedPages' => false));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

}
