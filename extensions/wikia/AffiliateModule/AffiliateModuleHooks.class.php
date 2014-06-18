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

		if ( self::canShowModule() ) {
			// Use a different position depending on whether the user is logged in
			$position = F::App()->wg->User->isAnon() ? 1300 : 1275;
			$modules[$position] = [ 'AffiliateModule', 'index', null ];
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Show the Module only on File pages, Article pages, and Main pages
	 * @return boolean
	 */
	public static function canShowModule() {
		$wg = F::app()->wg;
		$showableNameSpaces = array_merge( $wg->ContentNamespaces, [ NS_FILE ] );

		if ( $wg->Title->exists()
			&& in_array( $wg->Title->getNamespace(), $showableNameSpaces )
			&& in_array( $wg->request->getVal( 'action' ), [ 'view', null ] )
			&& $wg->request->getVal( 'diff' ) === null
		) {
			return true;
		}

		return false;
	}

}
