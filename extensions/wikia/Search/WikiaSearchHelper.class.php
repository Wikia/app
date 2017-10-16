<?php

class WikiaSearchHelper {
	const DEFAULT_LANG = 'en';
	const CENTRAL_WIKI_SEARCH = '/wiki/Special:Search';

	public function __construct() {
		$this->wikiaLogoHelper = new WikiaLogoHelper();
	}

	/**
	 * @desc This method appends /wiki/Special:Search to central URL.
	 * It appends not localized version because SpecialPage::getTitle returns value based on content language
	 * not user language.
	 *
	 * @param String $centralUrl - central wiki URL in given user language
	 * @return string - url to Special:Search page
	 */
	public function getGlobalSearchUrl( $centralUrl ) {
		return $centralUrl . self::CENTRAL_WIKI_SEARCH;
	}

	/**
	 * @desc get language for search results.
	 * If resultsLang param is set then use it if not get it from $wgLang
	 *
	 * @return String - language
	 */
	public function getLangForSearchResults() {
		global $wgLanguageCode, $wgRequest;

		return $wgRequest->getVal( 'resultsLang', $wgLanguageCode );
	}

	/**
	 * @desc get central wiki URL for given language.
	 * If central wiki in given language doesn't exist return default one (english)
	 *
	 * @param String $lang - language
	 * @return string - central wiki url
	 */
	public function getCentralUrlFromGlobalTitle( $lang ) {
		$title = $this->wikiaLogoHelper->getCentralWikiUrlForLangIfExists( $lang );
		if ( $title ) {
			return  $title->getServer();
		}

		$title = $this->wikiaLogoHelper->getCentralWikiUrlForLangIfExists( self::DEFAULT_LANG );
		if ( $title ) {
			return $title->getServer();
		}

		return '/';
	}
}
