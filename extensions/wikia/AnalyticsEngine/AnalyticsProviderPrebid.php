<?php

class AnalyticsProviderPrebid implements iAnalyticsProvider {
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/prebid.mustache';

	public static function isEnabled() {
		global $wgShowAds;

		return $wgShowAds && AdEngine2Service::areAdsShowableOnPage();
	}

	public function getSetupHtml( $params = array() ) {
		if ( self::isEnabled() ) {
			return \MustacheService::getInstance()->render( self::$template, [] );
		}
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
