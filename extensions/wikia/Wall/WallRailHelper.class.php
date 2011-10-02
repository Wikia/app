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
		
		if( $app->wg->Title->getNamespace() === NS_USER_WALL 
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
		
		$app->wf->ProfileOut(__METHOD__);
		return true;
	}
	
}