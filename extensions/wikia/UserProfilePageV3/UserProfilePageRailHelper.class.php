<?php

class UserProfilePageRailHelper {
	
	/**
	 * @brief Hooks into GetRailModuleList
	 * 
	 * @return boolean true
	 */
	public function onGetRailModuleList(&$modules) {
		$app = F::App();
		$app->wf->ProfileIn(__METHOD__);
		
		$pageOwner = F::build('User', array($app->wg->Title->getText()), 'newFromName');
		if( !$pageOwner->getOption('hidefollowedpages') ) {
			$modules[1101] = array('FollowedPages', 'Index', array('showDeletedPages' => false));
		}
		
		$app->wf->ProfileOut(__METHOD__);
		return true;
	}
	
}