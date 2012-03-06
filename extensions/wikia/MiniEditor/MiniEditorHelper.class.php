<?php

class MiniEditorHelper extends WikiaModel {

	/**
	 * Helper function for extensions integrating with the Mini Editor
	 * This will look at the request 'format' parameter and will return 
	 * the opposite format. html -> wikitext and wikitext -> html
	 * The second parameter is the name of the request parameter to convert ('body' or 'newbody' etc)
	 * If the second parameter is null, you can pass in raw text for conversion
	 */
	public static function convertRequestText(WikiaRequest $request, $requestParam, $rawText = null) {
		// $convertFormat is the desired format, i.e. convert to this format.  
		$convertFormat = $request->getVal('convertFormat', 'wikitext');

		if ($rawText != null) {
			$text = $rawText;

		} else {
			$text = $request->getVal($requestParam, null);
		}

		if ($convertFormat == 'RTEHtml') {
			$text = RTE::WikitextToHtml($text);

		} else {
			$text = RTE::HtmlToWikitext($text);
		}

		return $text;
	}

	public static function getAssets() {
		return array (
			// >> mediawiki editor core file
			'skins/common/edit.js',
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
			'extensions/wikia/EditPageLayout/js/modules/ButtonsList.js',
			'extensions/wikia/EditPageLayout/js/modules/FormatMiniEditor.js',
			'extensions/wikia/EditPageLayout/js/modules/FormatMiniEditorSource.js',
			'extensions/wikia/EditPageLayout/js/modules/Insert.js',
			'extensions/wikia/EditPageLayout/js/modules/InsertMiniEditor.js',
			'extensions/wikia/EditPageLayout/js/modules/ModeSwitch.js',
			// Load this on the fly with JSSnippets.  Only thing really needed is slider (so far)
			'skins/common/jquery/jquery-ui-1.8.14.custom.js',
			// plugins/extensions for MiniEditor
			'extensions/wikia/VideoEmbedTool/js/VET.js',
			'extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js',
			'extensions/wikia/WikiaMiniUpload/js/WMU.js',
			//'extensions/wikia/LinkSuggest/LinkSuggest.js'
		);
	}
}