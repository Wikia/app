<?php

class WallDisabledHooksHelper {
	
	/**
	 * @brief Checks if $dbkey is in wall/article comments format
	 * 
	 * @desc This is copy&pate from WallHelper. I didn't want to 
	 * bind WallDisabledHooksHelper with WallHelper when I need 
	 * only one method from it. It might have caused errors when
	 * other engineer add a Wall specific constants to WallHelper
	 * and don't check how the code works for wall disabled.
	 * 
	 * @param string $dbkey
	 */
	private function isDbkeyFromWall($dbkey) {
		$lookFor = explode( '\@' ,$dbkey);
		if (count($lookFor) > 0) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * @brief Redirects any attempts of editing anything in NS_USER_WALL namespace
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onAlternateEdit($editPage) {
		$app = F::App();
		$title = $app->wg->Title;
		
		if( empty($app->wg->EnableWallExt) && $this->isDbkeyFromWall($title->getText()) ) {
			$app->wg->Out->redirect($title->getLocalUrl(), 301);
			$app->wg->Out->enableRedirects(false);
		}
		
		return true;
	}
	
}
?>
