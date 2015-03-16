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
	 * @desc get central wiki URL for given language.
	 * If central wiki in given language doesn't exist return default one (english)
	 *
	 * @param String $lang - language
	 * @return string - central wiki url
	 */
	public function getCentralUrlFromGlobalTitle( $lang ) {
		$out = '/';

		$title = $this->getCentralWikiUrlForLangIfExists($lang);
		if ($title) {
			$out = $title->getServer();
		} else if ( $title = $this->getCentralWikiUrlForLangIfExists( self::DEFAULT_LANG ) ) {
			$out = $title->getServer();
		}

		return $out;
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
		global $wgLanguageCode, $wgRequest;

		$resultsLang = $wgRequest->getVal('resultsLang');
		if (!empty($resultsLang)) {
			return $resultsLang;
		} else {
			return $wgLanguageCode;
		}
	}

	/**
	 * @desc get central wiki URL for given language.
	 * If wiki in given language doesn't exist GlobalTitle method is throwing an exception and this method returns false
	 *
	 * @param String $lang - language code
	 * @return bool|GlobalTitle
	 */
	protected function getCentralWikiUrlForLangIfExists( $lang ) {
		try {
			$title = GlobalTitle::newMainPage( $this->wikiCorporateModel->getCorporateWikiIdByLang( $lang ) );
		} catch ( Exception $ex ) {
			return false;
		}
		return $title;
	}

	protected function createCNWUrlFromGlobalTitle() {
		return GlobalTitle::newFromText(
			'CreateNewWiki',
			NS_SPECIAL,
			WikiService::WIKIAGLOBAL_CITY_ID
		)->getFullURL();
	}
}
