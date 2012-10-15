<?php

/**
 * This editor allows for editing individual sentences. It strips the wikitext from
 * things that are too hard to edit, and leaves the splitting of sentences to a
 * class that implements the interface ISentenceDetection.
 *
 * It's very much possible to create an extension that inherits from this class to
 * do the detection another way, i.e. without the preprocessing and splitting.
 */
class SentenceEditor {
	/**
	 * This function hooks into InlineEditorMark and marks the sentences.
	 * @param $inlineEditorText InlineEditorText
	 */
	public static function mark( &$inlineEditorText ) {
		global $wgSentenceEditorDetectionDefault;

		// get the original wikitext
		$text = $inlineEditorText->getWikiOriginal();

		// preprocess the text by replacing everything difficult by spaces
		$text = self::preprocess( $text );

		// split what's left into sensible blocks of text
		$split = self::split( $text );

		// get the default detection class and make it able for extensions to alter it
		$detectionClass = $wgSentenceEditorDetectionDefault;
		wfRunHooks( 'SentenceEditorDetectionClass', array( &$detectionClass ) );

		// spawn the detection class and add the texts and position
		$detection = new $detectionClass();
		foreach ( $split as $wikiText ) {
			// $wikiText[0] is the text, $wikiText[1] is the position of that text
			$detection->addWikiText( $wikiText[0], $wikiText[1] );
		}

		// have the detection class add the markings to the InlineEditorText object,
		// class 'sentenceEditorElement', inline elements
		$detection->addMarkingsToText( $inlineEditorText, 'sentenceEditorElement inlineEditorBasic', false, false );

		return true;
	}

	/**
	 * Replaces all occurences of unsupported wikitext by spaces. This is to make sure the
	 * positions of what's left are still the same as those in the original wikitext
	 * @param $wikitext string
	 * @return string
	 */
	protected static function preprocess( $wikitext ) {
		$patterns = array();

		// remove references
		$patterns[] = '/(<ref[^>\/]*>.*?<\/ref>)/is';

		// remove references like <ref/>
		$patterns[] = '/(<ref.*?\/>)/i';

		// remove templates starting at the beginning of a line (or with whitespace)
		$patterns[] = '/^\s*(\{\{.*?\}\})/ms';
		$patterns[] = '/^\s*\|.*$/m';
		$patterns[] = '/^\s*\}\}/ms';

		// remove tables
		$patterns[] = '/(\{\|.*?\|\})/';

		// remove links with : in it
		$patterns[] = '/(\[\[[^:\[\]]*:[^:\[\]]*\]\])/';

		// remove headings
		$patterns[] = '/^(=+[^=]*=+)\s*$/m';

		// remove lists, indents, things like that
		$patterns[] = '/^[\*#:;](.*)$/m';

		return preg_replace_callback( $patterns, 'SentenceEditor::makeSpaces', $wikitext );
	}

	/**
	 * Function used by preprocess() to replace matches with spaces
	 * @param $matches array
	 * @return string
	 */
	protected static function makeSpaces ( $matches ) {
		return str_repeat( ' ', strlen( $matches[0] ) );
	}

	/**
	 * Splits the wikitext into pieces of actual text. A split is forced where there are
	 * two spaces or a newline. This way, it's possible to have the users define the sentences.
	 * @param $wikitext string
	 * @return array
	 */
	protected static function split( $wikitext ) {
		// split where there are at least two spaces, or a newline, or the beginning of the text
		$splits = preg_split( '/\s\s+|\n\s*|^/', $wikitext, -1, PREG_SPLIT_OFFSET_CAPTURE );

		// remove small occurences
		foreach ( $splits as $index => $split ) {
			if ( strlen( $split[0] ) < 2 ) unset( $splits[$index] );
		}

		return $splits;
	}
}
