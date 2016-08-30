<?php

/**
 * Class CrosslinkModuleHooks
 */
class CrosslinkModuleHooks {

	/**
	 * Insert crosslink module to the right rail
	 * @param array $modules
	 * @return bool
	 */
	public static function onGetRailModuleList( &$modules ) {
		$helper = new CrosslinkModuleHelper();
		if ( $helper->canShowModule() ) {
			$modules[1250] = [ 'CrosslinkModule', 'index', null ];
		}

		return true;
	}

}
