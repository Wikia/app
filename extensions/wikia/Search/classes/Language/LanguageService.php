<?php

/**
 * Class definition for Wikia\Search\Language\LanguageService
 */
namespace Wikia\Search\Language;

/**
 * Provides helper functions
 * @package Search
 * @subpackage Language
 */
class LanguageService {

	const WIKI_ARTICLE_THRESHOLD = 1;
	const ANY_LANG = '*';

	/**
	 * A string representation of language code
	 * @var string
	 */
	protected $lang;

	/**
	 * @var array
	 */
	protected $searchLanguageDefinitions = [
		'en' => [
			self::WIKI_ARTICLE_THRESHOLD => 50
		],
		'ja' => [
			self::WIKI_ARTICLE_THRESHOLD => 0
		],
		self::ANY_LANG => [
			self::WIKI_ARTICLE_THRESHOLD => 25
		],
	];

	/**
	 * @param $lang string
	 */
	public function setLanguageCode($lang) {
		$this->lang = $lang;
	}

	/**
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->lang;
	}

	public function getWikiArticlesThreshold() {
		$resultsLimit = $this->searchLanguageDefinitions[self::ANY_LANG][self::WIKI_ARTICLE_THRESHOLD];

		if ( isset( $this->searchLanguageDefinitions[$this->lang][self::WIKI_ARTICLE_THRESHOLD] ) ) {
			return $this->searchLanguageDefinitions[$this->lang][self::WIKI_ARTICLE_THRESHOLD];
		}

		return $resultsLimit;
	}

}
