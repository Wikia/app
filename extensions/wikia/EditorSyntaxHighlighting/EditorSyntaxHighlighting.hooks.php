<?php
namespace Wikia\EditorSyntaxHighlighting;

class EditorSyntaxHighlightingHooks {

	/**
	 * Add global variables for Javascript
	 * @param array $aVars
	 * @return bool
	 */
	public static function onEditPageMakeGlobalVariablesScript( array &$aVars ) {
		global $wgEnableEditorSyntaxHighlighting;
		$aVars['wgEnableEditorSyntaxHighlighting'] = $wgEnableEditorSyntaxHighlighting;
		return true;
	}

}
