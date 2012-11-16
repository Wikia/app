<?php

class SpellChecker extends WikiaObject {

	private $contentLanguage;
	private $script;
	private $user;

	function __construct() {
		parent::__construct();

		$this->contentLanguage = $this->app->getGlobal('wgContLang')->getCode();
		$this->script = $this->wg->Script;
		$this->user = $this->wg->User;
	}

	/**
	 * Add JavaScript variable with path to be used by AJAX requests sent by RTE plugin
	 */
	public function onRTEAddGlobalVariablesScript(Array &$vars) {
		wfProfileIn(__METHOD__);

		// check user preferences (enabled by default)
		if ($this->user->getOption('disablespellchecker')) {
			wfDebug(__METHOD__ . ": spell checker disabled in user preferences\n");
			wfProfileOut(__METHOD__);
			return true;
		}

		// check whether current content lang is supported by spellchecker
		$dict = new SpellCheckerDictionary();

		if ($dict->isLanguageSupported($this->contentLanguage)) {
			$vars['wgSpellCheckerLangIsSupported'] = true;
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
