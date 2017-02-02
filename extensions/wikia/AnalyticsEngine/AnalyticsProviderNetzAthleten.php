<?php

class AnalyticsProviderNetzAthleten implements iAnalyticsProvider {

	const TEMPLATE_PATH = 'extensions/wikia/AnalyticsEngine/templates/netzathleten.mustache';
	const DISABLED_MESSAGE = '<!-- NetzAthleten disabled -->';
	const URL = '//s.adadapter.netzathleten-media.de/API-1.0/NA-828433-1/naMediaAd.js';

	/**
	 * @param array $params
	 * @return null
	 */
	public function getSetupHtml( $params = array() ) {
		return null;
	}

	/**
	 * @param $eventName
	 * @param array $eventDetails
	 * @return string
	 */
	public function trackEvent( $eventName, $eventDetails = array() ) {
		return static::isEnabled() ? $this->getScript() : static::DISABLED_MESSAGE;
	}

	/**
	 * @return bool
	 */
	public static function isEnabled() {
		global $wgEnableNetzAthleten, $wgNoExternals;

		return $wgEnableNetzAthleten && !$wgNoExternals;
	}

	/**
	 * @return string
	 */
	private function getScript() {
		return \MustacheService::getInstance()->render( static::TEMPLATE_PATH, [
			'url' => static::URL
		] );
	}
}
