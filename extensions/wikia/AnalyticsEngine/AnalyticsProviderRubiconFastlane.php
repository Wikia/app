<?php

class AnalyticsProviderRubiconFastlane implements iAnalyticsProvider {
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/rubicon_fastlane.mustache';
	private static $wgCountriesVarName = 'wgAdDriverRubiconFastlaneCountries';

	public static function isEnabled() {
		global $wgAdDriverEnableRubiconFastlane, $wgShowAds;

		return $wgAdDriverEnableRubiconFastlane
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage();
	}

	public function getSetupHtml( $params = array() ) {
		static $called = false;

		if ( $called ) {
			return '';
		}

		$called = true;

		if ( static::isEnabled() ) {
			return \MustacheService::getInstance()->render(
				static::$template,
				[ 'wgCountriesVarName' => static::$wgCountriesVarName ]
			);
		}

		return '<!-- Rubicon Fastlane disabled -->';
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
