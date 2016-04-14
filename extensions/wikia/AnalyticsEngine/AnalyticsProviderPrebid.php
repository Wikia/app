<?php

class AnalyticsProviderPrebid implements iAnalyticsProvider {
	private static $url = '//acdn.adnxs.com/prebid/prebid.js';
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/prebid.mustache';

	public static function isEnabled() {
		global $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return $wgShowAds &&
			AdEngine2Service::areAdsShowableOnPage() &&
			!$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml( $params = array() ) {
		if ( self::isEnabled() ) {
			return \MustacheService::getInstance()->render(
				self::$template,
				[
					'url' => self::$url
				]
			);
		}
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
