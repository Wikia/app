<?php

class AnalyticsProviderIVW3 implements iAnalyticsProvider {

	private static $libraryUrl = 'https://script.ioam.de/iam.js';
	private static $siteId = 'wikia';
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/ivw3.mustache';

	static public function onInstantGlobalsGetVariables( array &$vars )
	{
		$vars[] = 'wgSitewideDisableIVW3';

		return true;
	}

	function getSetupHtml( $params = array() ) {
		return null;
	}

	function trackEvent( $event, $eventDetails = array() ) {
		if ( !self::isEnabled() ) {
			return '<!-- IVW3 disabled -->';
		}

		switch ($event) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				return $this->trackPageView();
			default:
				return '<!-- Unsupported event for IVW3 -->';
		}
	}

	static public function isEnabled() {
		global $wgSitewideDisableIVW3, $wgNoExternals, $wgAnalyticsDriverIVW3Countries;

		return !$wgSitewideDisableIVW3 && !$wgNoExternals && !empty( $wgAnalyticsDriverIVW3Countries );
	}

	private function trackPageView() {
		global $wgAnalyticsDriverIVW3Countries;

		return \MustacheService::getInstance()->render(
			self::$template,
			[
				'countries' => json_encode( $wgAnalyticsDriverIVW3Countries ),
				'siteId' => self::$siteId,
				'url' => self::$libraryUrl,
				'cmKey' => self::getCMKey()
			]
		);
	}

	static public function getCMKey() {
		$pageType = self::getPageType();
		$language = self::getMappedLanguage();
		$vertical = self::getVertical();

		return implode( '/', [ $vertical, $language, $pageType ] );
	}

	static private function getVertical() {
		global $wgCityId;

		$wikiFactoryHub = WikiFactoryHub::getInstance();

		return $wikiFactoryHub->getWikiVertical( $wgCityId )['short'];
	}

	static private function getPageType() {
		$wikiaPageType = new WikiaPageType();

		return $wikiaPageType->getPageType() === 'home' && $wikiaPageType->isCorporatePage() ? 'homepage' : 'not-homepage';
	}

	static private function getMappedLanguage() {
		global $wgTitle;
		$language = $wgTitle->getPageLanguage()->getCode();

		switch ( $language ) {
			case 'en':
				return 'pc';
			case 'de':
				return 'deut';
			default:
				return 'npc';
		}
	}
}
