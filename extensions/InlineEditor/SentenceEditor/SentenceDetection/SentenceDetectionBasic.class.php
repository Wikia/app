<?php

/**
 * Basic implementation of sentence splitting. Works until a certain degree, for Western languages.
 * It's recommended to use an algorithm that uses a trained data set for a specific language to get
 * better results.
 */
class SentenceDetectionBasic implements ISentenceDetection {
	private $wikiTexts;

	function __construct() {
		$this->wikiTexts = array();
	}

	public function addWikiText( $text, $offset ) {
		$this->wikiTexts[] = array( 'text' => $text, 'offset' => $offset );
	}

	/**
	 * Splits sentences at '.', '?' and '!', only when a dot is not one, two or three positions to the
	 * left or to the right of the character.
	 */
	public function addMarkingsToText( InlineEditorText &$inlineEditorText, $class, $block, $bar ) {
		foreach ( $this->wikiTexts as $wikiText ) {
			$sentences =  preg_split( "/(?<!\..|\...|\....)([\?\!\.]+)\s(?!.\.|..\.|...\.)/u", $wikiText['text'], -1,
				PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_DELIM_CAPTURE );

			foreach ( $sentences as $index => $sentence ) {
				if ( $index % 2 == 0 ) {
					if ( isset( $sentences[$index + 1] ) ) {
						$sentence[0] .= $sentences[$index + 1][0];
					}
					$start = $wikiText['offset'] + $sentence[1];
					$end   = $start + strlen( $sentence[0] );
					$inlineEditorText->addMarking( new InlineEditorMarking( $start, $end, $class, $block, $bar ) );
				}
			}
		}
	}
}
