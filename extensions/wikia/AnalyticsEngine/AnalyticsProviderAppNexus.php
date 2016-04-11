<?php

class AnalyticsProviderAppNexus implements iAnalyticsProvider {
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/appnexus.mustache';

	public static function isEnabled() {
		global $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return $wgEnableAdEngineExt &&
			$wgShowAds &&
			AdEngine2Service::areAdsShowableOnPage() &&
			!$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml( $params = array() ) {
		if ( self::isEnabled() ) {
			return \MustacheService::getInstance()->render(
				self::$template,
				[
					'wgCountriesVariable' => 'wgAdDriverAppNexusCountries'
				]
			);
		}
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
