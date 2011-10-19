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

}
