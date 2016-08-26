<?php

/**
 * Class SeoCrossLinkHooks
 */
class SeoCrossLinkHooks {

	/**
	 * Insert crosslink module to the right rail
	 * @param array $modules
	 * @return bool
	 */
	public static function onGetRailModuleList( &$modules ) {

		$helper = new SeoCrossLinkHelper();
		if ( $helper->canShowModule() ) {
			// Use a different position depending on whether the user is logged in
			$pos = F::App()->wg->User->isAnon() ? 1250 : 1300;
			$modules[$pos] = [ 'SeoCrossLink', 'index', null ];
		}

		return true;
	}

}
