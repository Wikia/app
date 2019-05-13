<?php

class AnalyticsProviderMoatYi implements iAnalyticsProvider {
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/moat-yi.mustache';

	public static function isEnabled() {
		global $wgShowAds;

		return $wgShowAds && AdEngine3Service::areAdsShowableOnPage();
	}

	public function getSetupHtml( $params = array() ) {
		if ( self::isEnabled() ) {
			return \MustacheService::getInstance()->render(self::$template, []);
		}

		return '';
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
