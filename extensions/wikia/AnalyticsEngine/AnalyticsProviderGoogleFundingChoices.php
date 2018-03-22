<?php

class AnalyticsProviderGoogleFundingChoices implements iAnalyticsProvider {

	private static $countriesVariable = 'wgAdDriverGoogleFundingChoicesCountries';
	private static $libraryUrl = 'https://contributor.google.com/scripts/63838b5c087240ba/loader.js';
	private static $bodyTemplate = 'extensions/wikia/AnalyticsEngine/templates/gfc.body.mustache';
	private static $headTemplate = 'extensions/wikia/AnalyticsEngine/templates/gfc.head.mustache';

	static public function isEnabledInHead() {
		global $wgEnableGoogleFundingChoices, $wgEnableGoogleFundingChoicesInHead, $wgNoExternals;

		return $wgEnableGoogleFundingChoices && $wgEnableGoogleFundingChoicesInHead && !$wgNoExternals;
	}

	static public function isEnabled() {
		global $wgEnableGoogleFundingChoices, $wgNoExternals;

		return !self::isEnabledInHead() && $wgEnableGoogleFundingChoices && !$wgNoExternals;
	}

	static public function onInstantGlobalsGetVariables( array &$vars ) {
		if ( !self::isEnabled() ) {
			return false;
		}

		$vars[] = self::$countriesVariable;

		return true;
	}

	static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		if ( !self::isEnabledInHead() ) {
			return true;
		}

		$scripts .= \MustacheService::getInstance()->render(
			self::$headTemplate,
			[
				'url' => self::$libraryUrl
			]
		);

		return true;
	}

	function getSetupHtml( $params = array() ) {
		return null;
	}

	function trackEvent( $event, $eventDetails = array() ) {
		if ( !self::isEnabled() ) {
			return '<!-- GFC disabled -->';
		}

		switch ( $event ) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				return \MustacheService::getInstance()->render(
					self::$bodyTemplate,
					[
						'url' => self::$libraryUrl,
						'wgCountriesVarName' => self::$countriesVariable
					]
				);
			default:
				return '<!-- Unsupported event for GFC -->';
		}
	}
}
