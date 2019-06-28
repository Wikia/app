<?php

class WikiaSearchHelper {

	// DEFAULT_LANG used to be 'en' but it has changed due to SER-3308
	const DEFAULT_LANG = 'search';
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
		// SER-3308: A hack to get community search working after the redirects have been changed in PLATFORM-3982.
		// Generally speaking, full community search (as opposed of community search results available in the right
		// rail of Special:Search's article result page) was built into Special:Search, so full community search is
		// only available on special "corporate" wiki communities. After the redirect changes (anything www.wikia.com
		// goes to www.fandom.com) the "corporate" English wiki got broken and a dedicated wiki for English community
		// search has been introduced: https://community-search.fandom.com/wiki/Special:Search.
		// This is a hack because it's hard to understand and requires a lot of context. It has been introduced for
		// two reasons: changing LANG_TO_WIKI_ID mapping so that 'en' maps to community-search.fandom.com will probably
		// have adverse effects AND as part of the unified-search project we're hoping to move community search out of
		// Special:Search by which we can remove this hack.
		if ( $lang == 'en' ) {
			$lang = self::DEFAULT_LANG;
		}

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
