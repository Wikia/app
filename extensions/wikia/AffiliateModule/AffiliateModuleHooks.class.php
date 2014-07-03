<?php

/**
 * Class AffiliateModuleHooks
 */
class AffiliateModuleHooks {

	/**
	 * Insert the AffiliateModule on to the right rail
	 * @param array $modules
	 * @return boolean
	 */
	public static function onGetRailModuleList( &$modules ) {
		wfProfileIn(__METHOD__);

		$location = AffiliateModuleHelper::LOCATION_RAIL;
		if ( AffiliateModuleHelper::canShowModule( $location ) ) {
			// Use a different position depending on whether the user is logged in
			$pos = F::App()->wg->User->isAnon() ? 1300 : 1275;
			$modules[$pos] = [ 'AffiliateModule', 'index', [ 'location' => $location ] ];
		}

		wfProfileOut(__METHOD__);

		return true;
	}

}
