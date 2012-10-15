<?php

/**
 * Simple editor for paragraphs.
 */
class ParagraphEditor {
	/**
	 * This function hooks into InlineEditorMark and marks the paragraphs.
	 * @param $inlineEditorText InlineEditorText
	 */
	public static function mark( &$inlineEditorText ) {
		// get the original wikitext
		$text = $inlineEditorText->getWikiOriginal();

		$matches = array();
		preg_match_all( '/(==+.+==+\s*\n)?((.|\n)*?)(\n\n|(\n==+.+==+\s*\n)|$)/', $text, $matches, PREG_OFFSET_CAPTURE );

		foreach ( $matches[2] as $match ) {
			$start = $match[1];
			$end   = $start + strlen( $match[0] );

			// do not include the trailing newline
			if ( substr( $match[0], -1 ) == "\n" ) $end--;

			$inlineEditorText->addMarking( new InlineEditorMarking( $start, $end, 'paragraphEditorElement inlineEditorBasic', true, true, 1 ) );
		}

		return true;
	}
}
