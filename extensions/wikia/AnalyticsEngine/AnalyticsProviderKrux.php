<?php

class AnalyticsProviderKrux implements iAnalyticsProvider {

	private static $siteId = 'JU3_GW1b';
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/krux.mustache';

	static function isEnabled() {
		global $wgEnableKruxTargeting, $wgNoExternals;

		return !$wgNoExternals && $wgEnableKruxTargeting && !AdTargeting::isDirectedAtChildren();
	}

	function getSetupHtml( $params = array() ) {
		return null;
	}

	function trackEvent( $event, $eventDetails = array() ) {
		if ( !self::isEnabled() ) {
			return '<!-- Krux disabled -->';
		}

		switch ($event) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				return $this->trackPageView();
			default:
				return '<!-- Unsupported event for Krux -->';
		}
	}

	private function trackPageView() {
		return \MustacheService::getInstance()->render(
			self::$template,
			[
				'siteId' => self::$siteId
			]
		);
	}
}
