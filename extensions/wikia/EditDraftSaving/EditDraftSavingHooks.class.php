<?php

class EditDraftSavingHooks {
	/**
	 * This hook is run when edit page is about to be rendered.
	 *
	 * Applies to RichTextEditor (RTE) and Mediawiki's source editor
	 *
	 * @param EditPage $editPage
	 */
	static public function onAlternateEdit(EditPage $editPage) {
		RequestContext::getMain()->getOutput()->addModules('ext.wikia.EditDraftSaving');
	}
}
