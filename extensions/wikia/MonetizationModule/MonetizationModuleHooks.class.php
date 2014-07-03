<?php

/**
 * Class MonetizationModuleHooks
 */
class MonetizationModuleHooks {

	/**
	 * Insert the Monetization Module on to the right rail
	 * @param array $modules
	 * @return boolean
	 */
	public static function onGetRailModuleList( &$modules ) {
		wfProfileIn(__METHOD__);

		$location = MonetizationModuleHelper::LOCATION_RAIL;
		if ( MonetizationModuleHelper::canShowModule( $location ) ) {
			// Use a different position depending on whether the user is logged in
			$pos = F::App()->wg->User->isAnon() ? 1300 : 1275;
			$modules[$pos] = [ 'MonetizationModule', 'index', [ 'location' => $location ] ];
		}

		wfProfileOut(__METHOD__);

		return true;
	}

}
