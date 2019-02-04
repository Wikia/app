<?php

class EditDraftSavingHooks {
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

		// TODO: load a different set of JS files when RTE is used on this edit page
		$output->addModules('ext.wikia.EditDraftSaving');
	}
}
