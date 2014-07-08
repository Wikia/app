<?php

/**
 * Class MonetizationModuleHelper
 */
class MonetizationModuleHelper extends WikiaModel {

	const LOCATION_RAIL = 'rail';
	const LOCATION_BOTTOM = 'bottom';
	const LOCATION_BOTTOM_ADS = 'bottom-ads';
	const LOCATION_ARTICLE_TITLE = 'article-title';
	const LOCATION_LOCAL_NAV = 'local-nav';
	const LOCATION_CATEGORIES = 'categories';

	/**
	 * Load assets only once
	 * @param string $location [rail/bottom/bottom-ads/article-title]
	 * @return boolean
	 */
	public static function canLoadAssets( $location ) {
		$options = F::app()->wg->MonetizationModuleOptions;
		reset( $options );
		if ( key( $options ) == $location ) {
			return true;
		}

		return false;
	}

	/**
	 * Replace ads with bottom module
	 * @param string $location
	 * @param Request $request
	 * @return boolean
	 */
	public static function replaceBottomAds( &$location, &$request ) {
		$wg = F::app()->wg;
		if ( $location == self::LOCATION_BOTTOM
			&& !empty( F::app()->wg->MonetizationModuleOptions[self::LOCATION_BOTTOM_ADS] )
		) {
			$location = MonetizationModuleHelper::LOCATION_BOTTOM_ADS;
			$request->setVal( 'location', $location );
			$wg->HideBottomAds = true;

			return true;
		}

		return false;
	}

	/**
	 * Show the Module only on File pages, Article pages, and Main pages
	 * @param string $location [rail/bottom/bottom-ads/article-title]
	 * @return boolean
	 */
	public static function canShowModule( $location ) {
		$wg = F::app()->wg;
		$showableNameSpaces = array_merge( $wg->ContentNamespaces, [ NS_FILE ] );

		if ( $wg->Title->exists()
			&& !$wg->Title->isMainPage()
			&& in_array( $wg->Title->getNamespace(), $showableNameSpaces )
			&& in_array( $wg->request->getVal( 'action' ), [ 'view', null ] )
			&& $wg->request->getVal( 'diff' ) === null
			&& !empty( $wg->MonetizationModuleOptions[$location] )
		) {
			return true;
		}

		return false;
	}

}
