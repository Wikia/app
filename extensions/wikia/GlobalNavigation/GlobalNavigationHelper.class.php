<?php

class GlobalNavigationHelper {

	const DEFAULT_LANG = 'en';
	const USE_LANG_PARAMETER = '?uselang=';
	const CENTRAL_WIKI_SEARCH = '/wiki/Special:Search';

	/**
	 * @var WikiaCorporateModel
	 */
	private $wikiCorporateModel;


	public function __construct() {
		$this->wikiCorporateModel = new WikiaCorporateModel();
	}

	/**
	 * @desc gets corporate page URL for given language.
	 * Firstly, it checks using GlobalTitle method.
	 * If entry for given language doesn't exist it checks in $wgLangToCentralMap variable
	 * If it doesn't exist it fallbacks to english version (default lang) using GlobalTitle method
	 *
	 * @param string $lang - language
	 * @return string - Corporate Wikia Domain for given language
	 */
	public function getCentralUrlForLang( $lang ) {
		global $wgLangToCentralMap;
		if ( $this->centralWikiInLangExists( $lang ) ) {
			return $this->getCentralWikiTitleForLang( $lang )->getServer();
		} else if ( !empty( $wgLangToCentralMap[ $lang ] ) ) {
			return $wgLangToCentralMap[ $lang ];
		} else {
			return $this->getCentralWikiTitleForLang( self::DEFAULT_LANG )->getServer();
		}
	}

	/**
	 * @desc get central wiki URL for given language.
	 * If central wiki in given language doesn't exist return default one (english)
	 *
	 * @param String $lang - language
	 * @return string - central wiki url
	 */
	public function getCentralUrlFromGlobalTitle( $lang ) {
		$currentLang = $this->centralWikiInLangExists( $lang ) ? $lang : self::DEFAULT_LANG;
		return $this->getCentralWikiTitleForLang( $currentLang )->getServer();
	}

	/**
	 * @desc get CNW url from GlobalTitle and append uselang
	 * if language is different than default (english)
	 *
	 * @param String $lang - language
	 * @return string - CNW url with uselang appended if necessary
	 */
	public function getCreateNewWikiUrl( $lang ) {
		$createWikiUrl = $this->createCNWUrlFromGlobalTitle();

		if ( $lang != self::DEFAULT_LANG ) {
			$createWikiUrl .= self::USE_LANG_PARAMETER . $lang;
		}
		return $createWikiUrl;
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
		global $wgLang, $wgRequest;

		$resultsLang = $wgRequest->getVal('resultsLang');
		if (!empty($resultsLang)) {
			return $resultsLang;
		} else {
			return $wgLang->getCode();
		}
	}

	protected function centralWikiInLangExists( $lang ) {
		try {
			GlobalTitle::newMainPage( $this->wikiCorporateModel->getCorporateWikiIdByLang( $lang ) );
		} catch ( Exception $ex ) {
			return false;
		}
		return true;
	}

	protected function getCentralWikiTitleForLang( $lang ) {
		return GlobalTitle::newMainPage( $this->wikiCorporateModel->getCorporateWikiIdByLang( $lang ) );
	}

	protected function createCNWUrlFromGlobalTitle() {
		return GlobalTitle::newFromText(
			'CreateNewWiki',
			NS_SPECIAL,
			WikiService::WIKIAGLOBAL_CITY_ID
		)->getFullURL();
	}
}
