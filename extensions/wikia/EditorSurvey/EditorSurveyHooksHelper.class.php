<?php

/**
 * EditorSurvey hooks helper class.
 */

class EditorSurveyHooksHelper {

	/**
	 * Set global variables for javascript
	 */
	public static function onMakeGlobalVariablesScript( Array &$vars ) {
		$vars[ 'wgEditorSurveyEnabled' ] = true;
		return true;
	}
}

