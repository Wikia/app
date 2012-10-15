<?php
/**
 * Entry point file for the WikiCitation extension.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Entry-point class for the WikiCitation extension.
 *
 * This is a static factory class, containing necessary entry points for
 * parser hooks. The class creates a parser (WCArgumentReader) to parse
 * the parser function. This class then calls the parser to create an
 * appropriate citation styler (children of WCStyle). This class also
 * creates an object (WCArticle) representing all the citations on a
 * single page.
 */
class WikiCitation {

	/**
	 * @var string citeID String containing a magic word representing the
	 *		parser function name. In English, it will be "cite", as in
	 *		{{#cite:...|...}.
	 */
	const citeID = 'wc_cite_tag';

	/**
	 * @var string biblioID String containing a magic word representing the
	 *		tag extension name. In English, it will be "biblio", as in
	 *		<biblio>...</biblio>.
	 */
	const biblioID = 'wc_biblio_tag';

	/**
	 * @var string noteID String containing a magic word representing the
	 *		tag extension name for notes. In English, it will be "note", as in
	 *		<note>...</note>.
	 */
	const noteID = 'wc_note_tag';

	/**
	 * @var string notesID String containing a magic word representing the
	 *		tag extension name for endnotes. In English, it will be "notes",
	 *      as in <notes>...</notes>.
	 */
	const endnotesID = 'wc_notes_tag';

	/**
	 * @var string notesID String containing a magic word representing the
	 *		tag extension name for a note section. In English, it will be
	 *      "notesection", as in <notesection>...</notesection>.
	 */
	const noteSectionID = 'wc_note_section_tag';

	/**
	 * An object representing a single article containing citations and/or
	 * a bibliography.
	 *
	 * @static
	 * @var WCArticle $article
	 */
	protected static $article;


	/**
	 * Handler for 'ParserFirstCallInit' parser hook.
	 *
	 * Called by Parser object to initialize the WikiCitation extension.
	 * Sets up parser hook, so that WikiCitation::parse(...) will be called
	 * whenever the parser encounters "{{#cite:...}}" or an equivalent
	 * localized expression, or the "<biblio>" tag.
	 *
	 * @static
	 * @param Parser $parser the Parser object calling this hook
	 */
	public static function onParserFirstCallInit( Parser $parser  ) {

		# Construct WCArticle object $article. The old $article, if it exists,
		# will be recovered by garbage collector.
		self::$article = new WCArticle();

		# Create parser function hook to $article->parseFunctionTemplate(...).
		$parser->setFunctionHook(
			self::citeID, # citeID is the magic word representing the parser function.
			'WikiCitation::parseFunctionTemplate', # the function Parser will call
			SFH_OBJECT_ARGS # The function call will be via PPNode_DOM arguments, rather than text,
			                # except for the first argument after the colon.
		);

		# Set hooks for biblio tag and its synonyms, if any.
		foreach( MagicWord::get( self::biblioID )->getSynonyms() as $synonym ) {
			$parser->setHook(
				$synonym,
				'WikiCitation::parseBibliographyTag'
			);
		}

		# Set hooks for note tag and its synonyms, if any.
		foreach( MagicWord::get( self::noteID )->getSynonyms() as $synonym ) {
			$parser->setHook(
				$synonym,
				'WikiCitation::parseNoteTag'
			);
		}

		# Set hooks for note section tag and its synonyms, if any.
		foreach( MagicWord::get( self::noteSectionID )->getSynonyms() as $synonym ) {
			$parser->setHook(
				$synonym,
				'WikiCitation::parseSectionTag'
			);
		}

		# Set hooks for endnote tag and its synonyms, if any.
		foreach( MagicWord::get( self::endnotesID )->getSynonyms() as $synonym ) {
			$parser->setHook(
				$synonym,
				'WikiCitation::parseNotesTag'
			);
		}

		# Associate style sheet with page.
		global $wgOut, $wgWCStyleSheet;
		$wgOut->addExtensionStyle( $wgWCStyleSheet );
		#$wgOut->addScript( '<link rel="stylesheet" type="text/css" media="any" href="' . $wgWCStyleSheet . '" />' );

		return True;
	}


	/**
	 * Parses the WikiCitation parser function and leaves marker in wikitext.
	 *
	 * This function is called by the Parser when it encounters the parser
	 * function "{{#cite:...}}" or an equivalent localized expression)
	 * Creates WCArgumentReader object to parse flags and parameters,
	 * then creates an appropriate child of class WCStyle based on the
	 * first parameter after the colon, then returns the citation as text.
	 * @remark Note that this $parser is guaranteed to be the same parser that
	 * initialized the object.
	 *
	 * @param Parser $parser = the parser
	 * @param PPFrame_DOM $frame = the DOM frame
	 * @param array $args = arguments
	 * @return array text
	 */
	public static function parseFunctionTemplate( Parser $parser, PPFrame_DOM $frame, array $args ) {
		if ( count( $args ) == 0 ) {
			return '';
		}
		try {
			$argumentReader = new WCArgumentReader( $parser, $frame, $args );
			$text = self::$article->parseCitation( $argumentReader );
		} catch ( WCException $e ) {
			# Exception messages appear in place of the citation.
			$text = '<strong class="' . WCStyle::citationHTML . ' ' . WCStyle::errorHTML . '">' . $e->getMessage() . '</strong>';
		}
		return $text;
	}


	/**
	 * Parses the <biblio> tag extension and leaves a marker in the wikitext.
	 *
	 * This function is called by the Parser when it encounters the parser
	 * function "<biblio>...</biblio>" or an equivalent localized expression).
	 *
	 * @param type $input     = the text within the tags
	 * @param array $args    = the HTML attributes
	 * @param Parser $parser = the parser object
	 * @param PPFrame $frame = the frame
	 * @return string
	 */
	public static function parseBibliographyTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		self::$article->startBibliography( $args );
		# Parse the text inside the <biblio> tags, which will contain embedded citations parser functions.
        $parser->recursiveTagParse( $input, $frame );
		return self::$article->endBibliography();
	}


	/**
	 * Parses the <note> tag extension and leaves a marker in the wikitext.
	 *
	 * This function is called by the Parser when it encounters the parser
	 * function "<note>...</note>" or an equivalent localized expression).
	 *
	 * @param type $input     = the text within the tags
	 * @param array $args    = the HTML attributes
	 * @param Parser $parser = the parser object
	 * @param PPFrame $frame = the frame
	 * @return string
	 */
	public static function parseNoteTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		self::$article->startNote( $args );
		# Parse the text inside the <note> tags, which will contain embedded citations.
        $output = $parser->recursiveTagParse( $input, $frame );
		# Leaves behind a single marker for the (probably subscripted) endnote marker.
		return self::$article->finishNote( $output );
	}


	/**
	 * Parses the <notesection> tag extension and returns an endnote section.
	 *
	 * This function is called by the Parser when it encounters the parser
	 * function "<notesection>...</notesection>" or an equivalent localized expression).
	 *
	 * @param type $input    = the text within the tags
	 * @param array $args    = the HTML attributes
	 * @param Parser $parser = the parser object
	 * @param PPFrame $frame = the frame
	 * @return string
	 */
	public static function parseSectionTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if ( $input ) {
			# If text is presented inside the <notes> tags, the text will appear first, followed
			# by the associated endnotes.
			self::$article->startSection( $args );
			# Parse the text inside the <notes> tags, which may contain embedded
			# parser functions.
			$output = $parser->recursiveTagParse( $input, $frame );
			# End the note section.
			self::$article->endSection();
			return output;
		} else {
			return '';
		}
	}


	/**
	 * Parses the <notes> tag extension and returns the endnote section.
	 *
	 * This function is called by the Parser when it encounters the parser
	 * function "<notes/>" or an equivalent localized expression).
	 *
	 * @param type $input     = the text within the tags
	 * @param array $args    = the HTML attributes
	 * @param Parser $parser = the parser object
	 * @param PPFrame $frame = the frame
	 * @return string
	 */
	public static function parseNotesTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		# Leaves a marker for all prior notes to this point within the notes section.
		return self::$article->markEndnotes();
	}


	/**
	 * Handler for 'ParseClearState' hook.
	 *
	 * Called by parser to clear the parser state. This function clears the
	 * WCArticle object.
	 *
	 * @static
	 * @param Parser $parser = the parser
	 */
	public static function onParserClearState( Parser $parser ) {
		self::$article->clear();
		return True;
	}


	/**
	 * Handler for 'ParserBeforeTidy' parser hook.
	 *
	 * Called by Parser object near the end of parsing. Renders citations in
	 * html and replaces the citation markers with the html citations.
	 * Also, this method links a style sheet to pages containing citations.
	 *
	 * @static
	 * @global type $wgOut
	 * @global type $wgWCStyleSheet
	 * @param Parser $parser = the parser
	 * @param string $text = the current parsed text of the article
	 */
	public static function onParserBeforeTidy( Parser $parser, &$text ) {
		# Insert citations.
		self::$article->render( $text );
		return True;
	}


}
