<?php

class AdEngine2Service {
	/**
	 * Check if for current page the ads can be displayed or not.
	 *
	 * @return bool
	 */
	public static function areAdsShowableOnPage() {
		return ( new AdEngine2PageTypeService() )->areAdsShowableOnPage();
	}

	public static function shouldShowAd( $pageTypes = null ) {
		$adEnginePageTypeService = new AdEngine2PageTypeService();

		$pageType = $adEnginePageTypeService->getPageType();

		if ( $pageTypes === null ) {
			$pageTypes = [AdEngine2PageTypeService::PAGE_TYPE_ALL_ADS];
		}

		if ( in_array( '*', $pageTypes ) && $pageType !== AdEngine2PageTypeService::PAGE_TYPE_NO_ADS ) {
			return true;
		}

		return in_array( $pageType, $pageTypes );
	}

	/**
	 * @deprecated
	 * @return array
	 */
	public static function getCachedCategory() {
		global $wgCityId;

		wfProfileIn( __METHOD__ );

		$hub = WikiFactoryHub::getInstance();
		$cat = array(
			'id' => $hub->getCategoryId( $wgCityId ),
			'short' => $hub->getCategoryShort( $wgCityId ),
		);

		wfProfileOut( __METHOD__ );

		return $cat;
	}
}
