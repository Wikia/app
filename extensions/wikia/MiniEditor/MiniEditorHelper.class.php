<?php

class MiniEditorHelper extends WikiaModel {

	/**
	 * Helper function for extensions integrating with the Mini Editor.
	 *
	 * @param $content The content to convert from the request object or passed in as a string
	 * @param $convertToFormat The format to convert to ('richtext' or 'wikitext')
	 */
	public static function convertContent($content = '', $convertToFormat = '') {
		return $convertToFormat == 'richtext' ? RTE::WikitextToHtml($content) : RTE::HtmlToWikitext($content);
	}
}