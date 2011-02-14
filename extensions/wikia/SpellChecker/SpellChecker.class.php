<?php

class SpellChecker {

	private $app;

	private $contentLanguage;
	private $script;
	private $user;

	function __construct() {
		$this->app = WF::build('App');

		$this->contentLanguage = $this->app->getGlobal('wgContLang')->getCode();
		$this->script = $this->app->getGlobal('wgScript');
		$this->user = $this->app->getGlobal('wgUser');
	}

	/**
	 * Add JavaScript variable with path to be used by AJAX requests sent by RTE plugin
	 */
	public function onRTEAddGlobalVariablesScript($vars) {
		wfProfileIn(__METHOD__);

		// check user preferences (enabled by default)
		if ($this->user->getOption('disablespellchecker')) {
			wfDebug(__METHOD__ . ": spell checker disabled in user preferences\n");
			return true;
		}

		// check whether current content lang is supported by spellchecker
		$dict = new SpellCheckerDictionary();
		$isSupported = $dict->isLanguageSupported($this->contentLanguage);

		$vars['wgSpellCheckerLangIsSupported'] = $isSupported;

		if ($isSupported) {
			$vars['wgSpellCheckerUrl'] = "{$this->script}?action=ajax&rs=SpellCheckerAjax";
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Add user preferences switch to enable spell checker
	 */
	public function onGetPreferences($user, &$preferences) {
		$preferences['disablespellchecker'] = array(
			'type' => 'toggle',
			'section' => 'editing/rte',
			'label-message' => 'enablespellchecker',
			'invert' => true, // when option is set to false (default value), checkbox is checked
		);

		return true;
	}
}
