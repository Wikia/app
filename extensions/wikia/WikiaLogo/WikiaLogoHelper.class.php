<?php

class WikiaLogoHelper {
	const DEFAULT_LANG = 'en';

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
	public function getCentralUrlForLang($lang) {
			global $wgLangToCentralMap;
			$centralUrl = '/';

			$title = $this->getCentralWikiUrlForLangIfExists( $lang );
			if ( $title ) {
				$centralUrl = $title->getServer();
			} else if ( !empty( $wgLangToCentralMap[ $lang ] ) ) {
				$centralUrl = $wgLangToCentralMap[ $lang ];
			} else if ($title = $this->getCentralWikiUrlForLangIfExists( self::DEFAULT_LANG ) ) {
				$centralUrl = $title->getServer();
			}

			return $centralUrl;
	}

	/**
	 * @desc get central wiki URL for given language.
	 * If wiki in given language doesn't exist GlobalTitle method is throwing an exception and this method returns false
	 *
	 * @param String $lang - language code
	 * @return bool|GlobalTitle
	 */
	public function getCentralWikiUrlForLangIfExists( $lang ) {
		try {
			return GlobalTitle::newMainPage( $this->wikiCorporateModel->getCorporateWikiIdByLang( $lang ) );
		} catch ( Exception $ex ) {
			return false;
		}
	}
}
