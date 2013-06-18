<?php

class SpellChecker {

	/**
	 * Add JavaScript variable with path to be used by AJAX requests sent by RTE plugin
	 */
	public static function onRTEAddGlobalVariablesScript(Array &$vars) {
		wfProfileIn(__METHOD__);

		$wg = F::app()->wg;

		// check user preferences (enabled by default)
		if ($wg->User->getOption('disablespellchecker')) {
			wfDebug(__METHOD__ . ": spell checker disabled in user preferences\n");
			wfProfileOut(__METHOD__);
			return true;
		}

		// check whether current content lang is supported by spellchecker
		$dict = new SpellCheckerDictionary();

		if ( $dict->isLanguageSupported( $wg->ContLang->getCode() ) ) {
			$vars['wgSpellCheckerLangIsSupported'] = true;
			$vars['wgSpellCheckerUrl'] = "{$wg->Script}?action=ajax&rs=SpellCheckerAjax";
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Add user preferences switch to enable spell checker
	 */
	public static function onGetPreferences($user, &$preferences) {
		$preferences['disablespellchecker'] = array(
			'type' => 'toggle',
			'section' => 'editing/rte',
			'label-message' => 'enablespellchecker',
			'invert' => true, // when option is set to false (default value), checkbox is checked
		);

		return true;
	}
}
