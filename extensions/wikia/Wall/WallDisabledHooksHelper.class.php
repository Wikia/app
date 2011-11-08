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
	 * 
	 * @return boolean
	 */
	private function isDbkeyFromWall($dbkey) {
		$lookFor = explode( '\@' ,$dbkey);
		if (count($lookFor) > 1) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * @brief Allows to edit or not archived talk pages and its subpages
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 * 
	 * @return boolean true -- because it's a hook
	 */
	public function onAfterEditPermissionErrors($permErrors, $title, $removeArray) {
		$app = F::App();
		
		if( empty($app->wg->EnableWallExt) && $this->isDbkeyFromWall($title->getText()) ) {
			$permErrors[] = array(
				0 => 'protectedpagetext',
				1 => 'archived'
			);
		}
		
		return true;
	}
	
}
?>
