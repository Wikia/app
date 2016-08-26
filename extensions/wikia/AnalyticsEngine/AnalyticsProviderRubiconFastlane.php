<?php

class AnalyticsProviderRubiconFastlane implements iAnalyticsProvider {
	const TEMPLATE = 'extensions/wikia/AnalyticsEngine/templates/rubicon_fastlane.mustache';
	const COUNTRIES_VARIABLE = 'wgAdDriverRubiconFastlaneCountries';

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
				static::TEMPLATE,
				[ 'wgCountriesVarName' => static::COUNTRIES_VARIABLE ]
			);
		}

		return '<!-- Rubicon Fastlane disabled -->';
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
