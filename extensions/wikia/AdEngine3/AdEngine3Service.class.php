<?php

class AdEngine3Service {
	/**
	 * Check if for current page the ads can be displayed or not.
	 *
	 * @return bool
	 */
	public static function areAdsShowableOnPage() {
		return ( new AdEngine3PageTypeService( new AdEngine3DeciderService() ) )->areAdsShowableOnPage();
	}

	public static function shouldShowAd( $pageTypes = null ) {
		$adEnginePageTypeService = new AdEngine3PageTypeService( new AdEngine3DeciderService() );

		$pageType = $adEnginePageTypeService->getPageType();

		if ( $pageTypes === null ) {
			$pageTypes = [AdEngine3PageTypeService::PAGE_TYPE_ALL_ADS];
		}

		if ( in_array( '*', $pageTypes ) && $pageType !== AdEngine3PageTypeService::PAGE_TYPE_NO_ADS ) {
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
