<?php

class AnalyticsProviderGoogleFundingChoices implements iAnalyticsProvider {

	private static $countriesVariable = 'wgAdDriverGoogleFundingChoicesCountries';
	private static $libraryUrl = 'https://contributor.google.com/scripts/63838b5c087240ba/loader.js';
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/gfc.mustache';

	static public function isEnabled() {
		global $wgEnableGoogleFundingChoices, $wgNoExternals;

		return $wgEnableGoogleFundingChoices && !$wgNoExternals;
	}

	static public function onInstantGlobalsGetVariables( array &$vars )
	{
		if ( !self::isEnabled() ) {
			return false;
		}

		$vars[] = self::$countriesVariable;

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
					self::$template,
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
