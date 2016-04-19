<?php

use Wikia\Util\Assert;

class AnalyticsProviderIVW3 implements iAnalyticsProvider {

	private static $libraryUrl = 'https://script.ioam.de/iam.js';
	private static $siteId = 'wikia';
	private static $template = 'extensions/wikia/AnalyticsEngine/templates/ivw3.mustache';
	private static $themes = [
		'111264/275' => 'none', // http://de.wikia.com/Wikia
		'111264/1824' => 'Angebotsinformation', // http://de.wikia.com/%C3%9Cber_Wikia
		'Hilfe' => 'Angebotsinformation', // http://de.community.wikia.com/wiki/Hilfe:%C3%9Cbersicht
		'111264/2305' => 'Angebotsinformation', // http://de.wikia.com/Stellen
		'Kontakt' => 'Angebotsinformation', // http://de.wikia.com/Spezial:Kontakt
		'111264/3780' => 'Angebotsinformation', // http://de.wikia.com/Nutzungsbedingungen
		'111264/2075' => 'Angebotsinformation', // http://de.wikia.com/Datenschutz
		'Sitemap' => 'Angebotsinformation', // http://www.wikia.com/Sitemap
		'111264/1927' => 'Angebotsinformation', // http://de.wikia.com/Presse
		'CommunityUserProfile' => 'SocialNetworkingPrivat', // http://de.community.wikia.com/wiki/Benutzer:ElBosso
		'WikiaAPI' => 'none', // http://api.wikia.com/wiki/Wikia_API_Wiki
		'CreateNewWikiDE' => 'none', // http://www.wikia.com/Special:CreateNewWiki?uselang=de
		'111264/2377' => 'Angebotsinformation', // http://de.wikia.com/Mobil
		'111264/2378' => 'Angebotsinformation', // http://de.wikia.com/Mobil/GameGuides
	];

	static public function onInstantGlobalsGetVariables( array &$vars ) {
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

		switch ( $event ) {
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
		$theme = self::getTheme();
		$vertical = self::getVertical();

		if ($theme !== '') {
			return implode( '/', [$vertical, self::getMappedLanguage(), self::getPageType(), $theme] );
		}

		return implode( '/', [$vertical, self::getMappedLanguage()] );
	}

	static private function getVertical() {
		global $wgCityId;

		$wikiFactoryHub = WikiFactoryHub::getInstance();

		return $wikiFactoryHub->getWikiVertical( $wgCityId )['short'];
	}

	static private function getPageType() {
		$wikiaPageType = new WikiaPageType();

		return $wikiaPageType->getPageType() === 'home' && $wikiaPageType->isCorporatePage() ?
			'homepage' : 'not-homepage';
	}

	static private function getMappedLanguage() {
		global $wgTitle;

		Assert::true( $wgTitle instanceof Title, __METHOD__ );

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

	static private function getTheme() {
		global $wgCityId, $wgTitle;

		Assert::true( $wgTitle instanceof Title, __METHOD__ );

		$isSpecial = ( new WikiaPageType() )->isSpecial();
		$language = $wgTitle->getPageLanguage()->getCode();
		$themeKey = implode( '/', [$wgCityId, $wgTitle->getArticleID()] );
		$title = $wgTitle->getText();
		$wgNamespaceNumber = $wgTitle->getNamespace();

		switch ( true ) {
			case array_key_exists( $themeKey, self::$themes ):
				return self::$themes[$themeKey];
			case $wgCityId == 1779 && $wgNamespaceNumber === 12:
				return self::$themes['Hilfe'];
			case $wgCityId == 352316:
				return self::$themes['WikiaAPI'];
			case $wgCityId == 80433 && $title === 'Sitemap':
				return self::$themes['Sitemap'];
			case $wgCityId == 111264 && $isSpecial && $title === 'Kontakt':
				return self::$themes['Kontakt'];
			case $wgCityId == 80433 && $language === 'de' && $isSpecial && $title === 'CreateNewWiki':
				return self::$themes['CreateNewWikiDE'];
			case $wgCityId == 1779 && $wgNamespaceNumber === 2:
				return self::$themes['CommunityUserProfile'];
			default:
				return '';
		}
	}
}
