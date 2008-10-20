<?php
class WysiwygParser extends Parser {

	/**
	 * Tag hook handler for 'pre'.
	 */
	function renderPreTag( $text, $attribs ) {
		// Backwards-compatibility hack
		$content = StringUtils::delimiterReplace( '<nowiki>', '</nowiki>', '$1', $text, 'i' );

		$attribs = Sanitizer::validateTagAttributes( $attribs, 'pre' );
		$attribs['wasHtml'] = 1;
		return wfOpenElement( 'pre', $attribs ) .
			Xml::escapeTagsOnly( $content ) .
			'</pre>';
	}

	function formatHeadings( $text, $isMain=true ) {
		return $text;
	}

	function doMagicLinks( $text ) {
		return $text;
	}

	function __construct( $conf = array() ) {
		parent::__construct($conf);

		// load hooks from $wgParser
		global $wgParser;
		$this->mTagHooks = & $wgParser->mTagHooks;
		$this->mStripList = & $wgParser->mStripList;
	}

}