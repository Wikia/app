<?php
namespace Wikia\EditorSyntaxHighlighting;

class EditorSyntaxHighlightingRegisterHooks {

	/**
	 * Register all hooks for extension
	 */
	public static function registerHooks() {
		$oHooks = new self();
		$oHooks->doRegisterHooks();
	}

	/**
	 * Actually register all hooks for extension
	 */
	public function doRegisterHooks() {
		$oHooks = $this->getHooks();
		\Hooks::register( 'EditPageMakeGlobalVariablesScript', [ $oHooks, 'onEditPageMakeGlobalVariablesScript' ] );
	}

	/**
	 * Returns new instance of ExactTargetUserHooks
	 * @return EditorSyntaxHighlightingHooks
	 */
	public function getHooks() {
		return new EditorSyntaxHighlightingHooks();
	}

}
