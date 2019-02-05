<?php

class EditDraftSavingHooks {

	// keep in sync with JavaScript code in js/index.js
	const EDIT_DRAFT_KEY_HIDDEN_FIELD = 'wpEditDraftKey';

	/**
	 * This hook is run when edit page is about to be rendered.
	 *
	 * Applies to RichTextEditor (RTE) and Mediawiki's source editor
	 *
	 * @param EditPage $editPage
	 * @param OutputPage $output
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/EditPage::showEditForm:initial
	 */
	static public function onEditPage_showEditForm_initial(EditPage $editPage, OutputPage $output) {
		$isRTEenabled = class_exists('RTE') && RTE::isEnabled();

		// load a different set of JS files when RTE is used on this edit page
		$output->addModules(
			$isRTEenabled
				? 'ext.wikia.EditDraftSaving.rte'
				: 'ext.wikia.EditDraftSaving.mediawiki'
		);
	}

	/**
	 * This hook is used to read the value of local storage's draft key name.
	 *
	 * This value is stored in PHP session and read by onMakeGlobalVariablesScript method below.
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ArticleSaveComplete
	 */
	static public function onArticleSaveComplete() {
		$request = RequestContext::getMain()->getRequest();
		$draftKey = $request->getVal( static::EDIT_DRAFT_KEY_HIDDEN_FIELD );

		if ( !empty( $draftKey ) ) {
			$_SESSION[ self::EDIT_DRAFT_KEY_HIDDEN_FIELD ] = $draftKey;
		}
	}

	/**
	 * (see the comment of the onArticleSaveComplete method)
	 *
	 * The value is read from PHP session on article reload after
	 * a successful article edit. It's then removed from local storage by a small JS code.
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/MakeGlobalVariablesScript
	 * @param array $vars
	 * @param OutputPage $out
	 */
	static public function onMakeGlobalVariablesScript(Array &$vars, OutputPage $out) {
		$draftKey = $out->getRequest()->getSessionData( self::EDIT_DRAFT_KEY_HIDDEN_FIELD );

		if (!$draftKey) {
			return;
		}

		// inject a small inline script to invalidate local storage entry
		$draftKeyEncoded = Xml::encodeJsVar($draftKey);

		$out->addInlineScript(<<<JS
// EditDraftSaving
(function() {
	try {
		localStorage.removeItem($draftKeyEncoded);
	} catch (e) {
		console.error(e);
	}
})();
JS
);

		// PHP session entry is no longer needed
		unset( $_SESSION[ self::EDIT_DRAFT_KEY_HIDDEN_FIELD ] );
	}

	/**
	 * Add a module for lazy loading VisualEditor handling.
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 *
	 * @param OutputPage $out
	 */
	static public function onBeforePageDisplay( OutputPage $out) {
		$out->addModuleScripts('ext.wikia.EditDraftSaving.ve.lazy');
	}
}
