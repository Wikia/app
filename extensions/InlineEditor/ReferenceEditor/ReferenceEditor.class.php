<?php

/**
 * Simple editor for references.
 */
class ReferenceEditor {
	/**
	 * This function hooks into InlineEditorMark and marks the references.
	 * @param $inlineEditorText InlineEditorText
	 */
	public static function mark( &$inlineEditorText ) {
		// get the original wikitext
		$text = $inlineEditorText->getWikiOriginal();

		$matches = array();
		preg_match_all( '/<ref[^\/]*?>.*?<\/ref>|<ref.*?\/>/is', $text, $matches, PREG_OFFSET_CAPTURE );

		foreach ( $matches[0] as $match ) {
			$start = $match[1];
			$end   = $start + strlen( $match[0] );
			$inlineEditorText->addMarking( new InlineEditorMarking( $start, $end, 'referenceEditorElement inlineEditorBasic', false, false ) );
		}

		return true;
	}
}
