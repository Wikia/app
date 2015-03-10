<?php
namespace Wikia\EditorSyntaxHighlighting;

class EditorSyntaxHighlightingHooks {

	/**
	 * Add global variables for Javascript
	 * @param array $aVars
	 * @return bool
	 */
	public static function onEditPageMakeGlobalVariablesScript( array &$aVars ) {
		$aVars['enableSyntaxHighlighting'] = \EditPageLayoutHelper::isSyntaxHighlightingEnabled();

		return true;
	}

}
