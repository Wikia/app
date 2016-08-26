<?php

class AnalyticsProviderRubiconFastlane implements iAnalyticsProvider {
	const COUNTRIES_VARIABLE = 'wgAdDriverRubiconFastlaneCountries';
	const MODULE_NAME = 'ext.wikia.adEngine.lookup.rubiconFastlane';
	const TEMPLATE = 'extensions/wikia/AnalyticsEngine/templates/bidder.mustache';

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
				[
					'moduleName' => static::MODULE_NAME,
					'wgCountriesVariable' => static::COUNTRIES_VARIABLE
				]
			);
		}

		return '<!-- Rubicon Fastlane disabled -->';
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
