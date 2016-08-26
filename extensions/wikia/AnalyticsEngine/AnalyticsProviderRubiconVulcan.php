<?php

class AnalyticsProviderRubiconVulcan implements iAnalyticsProvider {
	const COUNTRIES_VARIABLE = 'wgAdDriverRubiconVulcanCountries';
	const MODULE_NAME = 'ext.wikia.adEngine.lookup.rubiconVulcan';
	const TEMPLATE = 'extensions/wikia/AnalyticsEngine/templates/bidder.mustache';

	public static function isEnabled() {
		global $wgAdDriverEnableRubiconVulcan, $wgShowAds;

		return $wgAdDriverEnableRubiconVulcan
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

		return '<!-- Rubicon Vulcan disabled -->';
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
