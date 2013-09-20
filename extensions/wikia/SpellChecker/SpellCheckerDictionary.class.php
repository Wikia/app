<?php

class SpellCheckerDictionary extends WikiaObject {

	private $broker;
	private $dict;
	private $path;

	function __construct($langCode = null) {
		wfProfileIn(__METHOD__);

		parent::__construct();

		// create a new broker object
		$this->broker = enchant_broker_init();

		// set path to directory with extra dictionaries
		// @see http://blog.iwanluijks.nl/2010/10/using-enchant-with-php-on-windows-part.html
		$ip = $this->app->getGlobal('IP');
		$this->path = "{$ip}/lib/vendor/dicts";

		enchant_broker_set_dict_path($this->broker, ENCHANT_MYSPELL, $this->path);
		enchant_broker_set_dict_path($this->broker, ENCHANT_ISPELL, $this->path);

		// try to load dictionary
		if (!empty($langCode)) {
			$this->load($langCode);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Load dictionary for given language code
	 */
	public function load($langCode) {
		wfProfileIn(__METHOD__);
		$langCode = strtolower($langCode);

		self::log(__METHOD__, "trying to load dictionary for '{$langCode}'...");

		// set providers priority
		enchant_broker_set_ordering($this->broker, '*', 'myspell,aspell');

		// if there's no dictionary for 'it', try to request dictionary for 'it_IT'
		if (!enchant_broker_dict_exists($this->broker, $langCode)) {
			$langCode = $langCode . '_' . strtoupper($langCode);
		}

		// check if dictionary exists
		if (enchant_broker_dict_exists($this->broker, $langCode)) {
			wfProfileIn(__METHOD__ . '::requestDict');
			$this->dict = enchant_broker_request_dict($this->broker, $langCode);
			wfProfileOut(__METHOD__ . '::requestDict');
		}

		if ($this->isLoaded()) {
			$info = $this->describe();
			self::log(__METHOD__, "loaded '{$info['lang']}' provided by {$info['desc']}");
		}
		else {
			self::log(__METHOD__, "unable to load dictionary for '{$langCode}'!");
		}

		wfProfileOut(__METHOD__);
		return $this->isLoaded();
	}

	/**
	 * Check whether dictionary is loaded
	 */
	public function isLoaded() {
		return is_resource($this->dict);
	}

	/**
	 * Return path to directory with custom dictionaries
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Return whether given language has dictionary
	 */
	public function isLanguageSupported($lang) {
		wfProfileIn(__METHOD__);

		$languages = $this->getLanguages();
		$isSupported = in_array($lang, $languages);

		wfProfileOut(__METHOD__);
		return $isSupported;
	}

	/**
	 * Check whether a word is correctly spelled or not
	 */
	public function check($word) {
		wfProfileIn(__METHOD__);

		$ret = $this->isLoaded() && enchant_dict_check($this->dict, $word);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Return an array of suggestions if the word is wrongly spelled
	 */
	public function suggest($word) {
		wfProfileIn(__METHOD__);

		$ret = $this->isLoaded() ? (array) enchant_dict_suggest($this->dict, $word) : false;

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Check whether a word is correctly spelled and return list suggestions if the word is wrongly spelled
	 */
	public function quickCheck($word) {
		wfProfileIn(__METHOD__);

		$ret = false;

		if ($this->isLoaded()) {
			$suggestions = array();
			$ret = enchant_dict_quick_check($this->dict, $word, $suggestions);

			// return suggestions if word is misspelled
			if ($ret == false) {
				$ret = $suggestions;
			}
			else {
				$ret = true;
			}
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Describes current dictionary
	 */
	public function describe() {
		return $this->isLoaded() ? enchant_dict_describe($this->dict) : false;
	}

	/**
	 * Add given word to current session of spell checking
	 */
	public function addWord($word) {
		return $this->isLoaded() && enchant_dict_add_to_session($this->dict, $word);
	}

	/**
	 * Get list of available dictionaries (using short language codes, the one used by MW)
	 */
	public function getLanguages() {
		wfProfileIn(__METHOD__);

		$languages = array();
		$dictionaries = enchant_broker_list_dicts($this->broker);

		foreach($dictionaries as $dictionary) {
			list($langCode) = explode('_', $dictionary['lang_tag']);

			$languages[$langCode] = true;
		}

		$languages = array_keys($languages);
		sort($languages);

		wfProfileOut(__METHOD__);
		return $languages;
	}

	/**
	 * Get list of available spell checking providers and their dictionaries
	 */
	public function getProviders() {
		wfProfileIn(__METHOD__);

		$providers = array();
		$dictionaries = enchant_broker_list_dicts($this->broker);

		// group available dicionaries by provider
		foreach($dictionaries as $dictionary) {
			$providers[$dictionary['provider_desc']][] = $dictionary['lang_tag'];
		}

		wfProfileOut(__METHOD__);
		return $providers;
	}

	/**
	 * Helper method for logging
	 */
	static public function log($method, $msg) {
		wfDebug("{$method}: {$msg}\n");
	}
}
