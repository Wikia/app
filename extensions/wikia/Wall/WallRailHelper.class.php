<?php

class WallRailHelper {
	
	/**
	 * @brief Hooks into GetRailModuleList
	 * 
	 * @return boolean true
	 */
	public function onGetRailModuleList(&$modules) {
		$app = F::App();
		$app->wf->ProfileIn(__METHOD__);
		
		$namespace = $app->wg->Title->getNamespace();
		$action = $app->wg->Request->getVal('action', null);
		
		if( $action !== 'history' 
			&& $namespace === NS_USER_WALL 
			&& !$app->wg->Title->isSubpage()
		) {
			//we want only chat, achivements and following pages
			$remove = array(1250, 1450, 1300, 1150);
			foreach($remove as $rightRailEl) {
				if( !empty($modules[$rightRailEl]) ) {
					unset($modules[$rightRailEl]);
				}
			}
		}
		
		if( $action === 'history' && ($namespace === NS_USER_WALL || $namespace === NS_USER_WALL_MESSAGE) ) {
			$modules = array();
			$modules[1441] = array('Search', 'Index', null);
			$modules[1440] = array('WallRail', 'index', null);
		}
		
		$app->wf->ProfileOut(__METHOD__);
		return true;
	}
	
}
