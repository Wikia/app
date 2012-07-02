<?php

class SpellCheckerService extends WikiaService {

	private $dict;
	private $lang;

	function __construct($lang) {
		parent::__construct();

		$this->dict = new SpellCheckerDictionary($lang);
		$this->lang = $lang;

		// add extra words for this session only
		$this->addExtraWords();
	}

	/**
	 * Check whether dictionary is loaded
	 */
	public function isLoaded() {
		return $this->dict->isLoaded();
	}

	/**
	 * Return information about currently used dictionary
	 */
	public function getInfo() {
		return $this->dict->isLoaded() ? $this->dict->describe() : false;
	}

	/**
	 * Add words from:
	 *   * $wgSpellCheckerExtraWordsGlobal
	 *   * $wgSpellCheckerExtraWords(langcode)
	 *   * MediaWiki:Dictionary message
	 * to current dictionary (for this session only)
	 */
	private function addExtraWords() {
		wfProfileIn(__METHOD__);
		$words = array();

		// add "global" extra words
		$words = array_merge($words, (array) $this->app->getGlobal('wgSpellCheckerExtraWordsGlobal'));

		// add "per language" extra words
		$variableName = 'wgSpellCheckerExtraWords' . ucfirst($this->lang);
		$words = array_merge($words, (array) $this->app->getGlobal($variableName));

		// add "per wiki: extra words (from MediaWiki:Dictionary)
		$localDictionary = Wikia::parseMessageToArray('dictionary', true /* use wfMsgForContent() */);
		$words = array_merge($words, $localDictionary);

		// remove duplicated words
		$words = array_unique($words);

		//var_dump($words);

		if (!empty($words)) {
			foreach($words as $word) {
				$this->dict->addWord($word);
			}

			$wordsCount = count($words);
			wfDebug(__METHOD__ . ": {$wordsCount} extra words added to the dictionary\n");
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Perform spell checking of given list of words using dictionary for current language
	 */
	public function checkWords($words) {
		wfProfileIn(__METHOD__);
		$ret = false;

		if (count($words) > 0 && $this->dict->isLoaded()) {
			$ret = array();
			$suggestions = array();
			$correct = 0;

			// check each word and eventually get spell suggestions
			foreach($words as $word) {
				$data = $this->dict->quickCheck($word);
				if ($data === true) {
					$correct++;
				}
				else {
					$suggestions[$word] = $data;
				}
			}

			$ret['correct'] = $correct;
			$ret['suggestions'] = $suggestions;

			// add dictionary info
			$info = $this->dict->describe();
			$ret['info'] = array(
				'lang' => $info['lang'],
				'provider' => !empty($info['desc'])?$info['desc']:false,
			);
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Perform spell checking for a single word
	 */
	public function checkWord($word) {
		return $this->dict->isLoaded() ? $this->dict->quickCheck($word) : null;
	}
}
