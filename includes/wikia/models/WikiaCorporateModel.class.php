<?php

class WikiaCorporateModel extends WikiaModel {

	// taken from wgEnableWikiaHomePageExt
	const LANG_TO_WIKI_ID = [
		'en' => Wikia::CORPORATE_WIKI_ID,
		'de' => 111264,
		'fr' => 208826,
		'pl' => 435095,
		'es' => 637291,
		'ja' => 875569,
	];

	/**
	 * Get corporate wikiId by content lang
	 *
	 * @param string $lang
	 * @return int
	 * @throws WikiaException
	 */
	public function getCorporateWikiIdByLang($lang) {
		if (!isset(self::LANG_TO_WIKI_ID[$lang])) {
			throw new WikiaException('Corporate Wiki not defined for this lang');
		}

		return self::LANG_TO_WIKI_ID[$lang];
	}
}
