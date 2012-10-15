<?php

/**
 * Simple editor for media (images, video, sound).
 */
class MediaEditor {
	/**
	 * This function hooks into InlineEditorMark and marks the media.
	 * @param $inlineEditorText InlineEditorText
	 */
	public static function mark( &$inlineEditorText ) {
		// get the original wikitext
		$text = $inlineEditorText->getWikiOriginal();

		$matches = array();
		preg_match_all( '/^\s*(\[\[(.*:.*)\]\])\s*$/m', $text, $matches, PREG_OFFSET_CAPTURE );

		foreach ( $matches[1] as $id => $match ) {
			$link = $matches[2][$id][0];
			$firstPipe = strpos( $link, '|' );
			if ( $firstPipe !== false ) {
				$url = substr( $link, 0, $firstPipe );
			}
			else {
				$url = $link;
			}

			$title = Title::newFromText( $url );
			$namespace = $title->getNamespace();

			if ( $namespace == NS_FILE ) {
				$start = $match[1];
				$end   = $start + strlen( $match[0] );
				$inlineEditorText->addMarking( new InlineEditorMarking( $start, $end, 'mediaEditorElement inlineEditorBasic', true, false, 0, false ) );
			}
		}

		return true;
	}
}
