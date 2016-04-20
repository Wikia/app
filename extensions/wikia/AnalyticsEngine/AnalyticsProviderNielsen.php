<?php

class AnalyticsProviderNielsen implements iAnalyticsProvider {

	private static $apid = 'T26086A07-C7FB-4124-A679-8AC404198BA7';
	private static $bodyTemplate = 'extensions/wikia/AnalyticsEngine/templates/nielsen.body.mustache';
	private static $headTemplate = 'extensions/wikia/AnalyticsEngine/templates/nielsen.head.mustache';
	private static $libraryUrl = 'http://secure-dcr-cert.imrworldwide.com/novms/js/2/ggcmb500.js';

	function getSetupHtml( $params=array() ) {
		return null;
	}

	function trackEvent( $event, $eventDetails = array() ) {
		global $wgCityId, $wgDBname;

		if ( !self::isEnabled() ) {
			return;
		}

		switch ( $event ) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				return \MustacheService::getInstance()->render(
					self::$bodyTemplate,
					[
						'appId' => self::$apid,
						'section' => HubService::getVerticalNameForComscore( $wgCityId ),
						'dbName' => $wgDBname
					]
				);
			default:
				return '<!-- Unsupported event for Nielsen -->';
		}
	}

	static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		if ( !self::isEnabled() ) {
			$scripts .= '<!-- Nielsen is disabled -->';
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

	static public function isEnabled() {
		global $wgEnableNielsen, $wgNoExternals;

		return $wgEnableNielsen && !$wgNoExternals;
	}
}
