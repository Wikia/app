<?php

/**
 * Simple editor for templates.
 */
class TemplateEditor {
	/**
	 * This function hooks into InlineEditorMark and marks the media.
	 * @param $inlineEditorText InlineEditorText
	 */
	public static function mark( &$inlineEditorText ) {
		// get the original wikitext
		$text = $inlineEditorText->getWikiOriginal();

		$matches = array();
		preg_match_all( '/^(\{\{.*?\}\})/ms', $text, $matches, PREG_OFFSET_CAPTURE );

		foreach ( $matches[0] as $match ) {
			$start = $match[1];
			$end   = $start + strlen( $match[0] );
			$inlineEditorText->addMarking( new InlineEditorMarking( $start, $end, 'templateEditorElement inlineEditorBasic', true, false, 0, false ) );
		}

		return true;
	}
}
