<?php

class AnalyticsProviderNetzAthleten implements iAnalyticsProvider {

	const TEMPLATE_PATH = 'extensions/wikia/AnalyticsEngine/templates/netzathleten.mustache';
	const DISABLED_MESSAGE = '<!-- NetzAthleten disabled -->';
	const URL = '//tag.md-nx.com/nx/438359d5-7944-441e-8720-1ab8a1f65560/loader.js';

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
