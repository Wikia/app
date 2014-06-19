<?php

/**
 * Class AffiliateModuleHelper
 */
class AffiliateModuleHelper extends WikiaModel {

	/**
	 * Show the Module only on File pages, Article pages, and Main pages
	 * @param string $option [rail/bottom/bottomAds]
	 * @return boolean
	 */
	public static function canShowModule( $option = 'bottom' ) {
		$wg = F::app()->wg;
		$showableNameSpaces = array_merge( $wg->ContentNamespaces, [ NS_FILE ] );

		if ( $wg->Title->exists()
			&& in_array( $wg->Title->getNamespace(), $showableNameSpaces )
			&& in_array( $wg->request->getVal( 'action' ), [ 'view', null ] )
			&& $wg->request->getVal( 'diff' ) === null
			&& !empty( $wg->AffiliateModuleOptions[$option] )
		) {
			return true;
		}

		return false;
	}

}
