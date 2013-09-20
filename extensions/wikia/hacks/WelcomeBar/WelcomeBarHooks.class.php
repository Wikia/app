<?php

class WelcomeBarHooks extends WikiaObject {

	/**
	 * Load WelcomeBar front-end code for anonymous visitors only
	 *
	 * @param Skin $skin current skin object
	 * @param string $text content of bottom scripts
	 * @return boolean it't a hook
	 */
	public function onSkinAfterBottomScripts(Skin $skin, &$text) {
		if ($this->wg->User->isAnon()) {
			$text .= JSSnippets::addToStack(
				array('/extensions/wikia/hacks/WelcomeBar/js/WelcomeBar.js'),
				array(),
				'WelcomeBar.init'
			);
		}

		return true;
	}
}
