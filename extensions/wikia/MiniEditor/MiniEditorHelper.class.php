<?php

class MiniEditorHelper extends WikiaModel {

	// For now just add the MiniEditor enabled var on NS_USER_WALL namespace
	// When MiniEditor is added to other page types, this logic will have to change
	public static function makeGlobalVariablesScript(&$vars) {
		global $wgTitle;
		if ($wgTitle->getNamespace() == NS_USER_WALL ||
			class_exists('ArticleCommentInit') && ArticleCommentInit::ArticleCommentCheck() ||
			$wgTitle->isSpecial( 'MiniEditor' )) {
			$vars['wgEnableMiniEditorExt'] = true;
		}
		return true;
	}

	// TODO: remove any that are not needed for MiniEditor
	static public function getAssets() {
		return array (
			// >> mediawiki editor core file
			'skins/common/edit.js',
			// >> editor stack loaders and configurers
			'extensions/wikia/EditPageLayout/js/loaders/MiniEditorLoader.js',
			// >> editor core
			'extensions/wikia/EditPageLayout/js/editor/WikiaEditor.js',
			'extensions/wikia/EditPageLayout/js/editor/Buttons.js',
			'extensions/wikia/EditPageLayout/js/editor/Modules.js',
			// >> Wikia specific editor plugins
			'extensions/wikia/EditPageLayout/js/plugins/MiniEditor.js',
			'extensions/wikia/EditPageLayout/js/plugins/Tracker.js',
			'extensions/wikia/EditPageLayout/js/plugins/Collapsiblemodules.js',
			'extensions/wikia/EditPageLayout/js/plugins/Cssloadcheck.js',
			'extensions/wikia/EditPageLayout/js/plugins/Edittools.js',
			'extensions/wikia/EditPageLayout/js/plugins/Loadingstatus.js',
			// >> extras (mainly things which should be moved elsewhere)
			'extensions/wikia/EditPageLayout/js/extras/Buttons.js',
			// >> visual modules - toolbars etc.
			'extensions/wikia/EditPageLayout/js/modules/Container.js',
			//'extensions/wikia/EditPageLayout/js/modules/RailContainer.js',
			'extensions/wikia/EditPageLayout/js/modules/ButtonsList.js',
			//'extensions/wikia/EditPageLayout/js/modules/Format.js',
			'extensions/wikia/EditPageLayout/js/modules/FormatMiniEditor.js',
			'extensions/wikia/EditPageLayout/js/modules/FormatMiniEditorSource.js',
			//'extensions/wikia/EditPageLayout/js/modules/FormatExpanded.js',
			'extensions/wikia/EditPageLayout/js/modules/Insert.js',
			'extensions/wikia/EditPageLayout/js/modules/InsertMiniEditor.js',
			'extensions/wikia/EditPageLayout/js/modules/ModeSwitch.js',
			// Load this on the fly with JSSnippets.  Only thing really needed is slider (so far)
			'skins/common/jquery/jquery-ui-1.8.14.custom.js',
			// plugins/extensions for MiniEditor
			'extensions/wikia/VideoEmbedTool/js/VET.js',
			'extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js',
			'extensions/wikia/WikiaMiniUpload/js/WMU.js'//,
			//'extensions/wikia/LinkSuggest/LinkSuggest.js'
		);
	}
}