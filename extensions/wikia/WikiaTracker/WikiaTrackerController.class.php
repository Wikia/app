<?php

class WikiaTrackerController extends WikiaController {

	/**
	 * Add global JS variables with GoogleAnalytics and WikiaTracker queues
	 *
	 * @param array $vars global variables list
	 * @return boolean return true
	 */
	public function onMakeGlobalVariablesScript($vars) {
		$vars['_gaq'] = array();
		$vars['_wtq'] = array();

		return true;
	}

	/**
	 * Add inline JS in <head> section
	 *
	 * @param string $scripts inline JS scripts
	 * @return boolean return true
	 */
	public function onSkinGetHeadScripts($scripts) {
		// used for page load time tracking
		$scripts .= "\n\n<!-- Used for page load time tracking -->\n" .
			Html::inlineScript("var wgNow = new Date();") .
			"\n";

		// debug
		/**
		$scripts .= Html::inlineScript(<<<JS
_wtq.push('/1_wikia/foo/bar');
_wtq.push(['/1_wikia/foo/bar', 'profil1']);
_wtq.push([['1_wikia', 'user', 'foo', 'bar'], 'profil1']);
JS
);
		**/

		return true;
	}

}
