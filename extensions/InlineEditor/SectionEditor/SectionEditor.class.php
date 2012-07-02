<?php

/**
 * Simple editor for sections.
 */
class SectionEditor {
	/**
	 * This function hooks into InlineEditorMark and marks the sections.
	 * @param $inlineEditorText InlineEditorText
	 */
	public static function mark( &$inlineEditorText ) {
		// get the original wikitext
		$text = $inlineEditorText->getWikiOriginal();

		$matches = array();
		preg_match_all( '/==+.+==+\s*\n/', $text, $matches, PREG_OFFSET_CAPTURE );
		
		$matches[0][] = array( '', strlen($text)+1 );
		
		$prevPos = 0;
		foreach ( $matches[0] as $match ) {
			$start   = $prevPos;
			$end     = $match[1]-1;
			$prevPos = $match[1];

			$inlineEditorText->addMarking( new InlineEditorMarking( $start, $end, 'sectionEditorElement inlineEditorBasic', true, true, 2 ) );
		}

		return true;
	}
}
