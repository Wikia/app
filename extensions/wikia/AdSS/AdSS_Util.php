<?php

class AdSS_Util {

	static function getSitePricing() {
		global $wgAdSS_pricingConf;
		return $wgAdSS_pricingConf['site'];
	}

	static function getPagePricing( $title=null ) {
		global $wgAdSS_pricingConf;

		if( $title ) {
			if( isset( $wgAdSS_pricingConf['page'][$title->getText()] ) ) {
				return $wgAdSS_pricingConf['page'][$title->getText()];
			} elseif( isset( $wgAdSS_pricingConf['page']['#mainpage#'] )
					&& $title->equals( Title::newMainPage() ) ) {
				return $wgAdSS_pricingConf['page']['#mainpage#'];
			} 
		}
		return $wgAdSS_pricingConf['page']['#default#'];
	}

	//FIXME temporary hack
	static function flushCache() {
		global $wgMemc, $wgScriptPath;
		$memcKey = wfMemcKey( 'adss', 'siteads' );
		$wgMemc->delete( $memcKey );

		$url = $wgScriptPath . '?action=ajax&rs=AdSS_Publisher::getSiteAdsAjax';
		SquidUpdate::purge( array( $url ) );
	}
}
