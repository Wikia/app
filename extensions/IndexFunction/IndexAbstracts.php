<?php

/**
 * Class to extract the first bit of text from an article
 * Adapted from the OpenSearchXML extension, by Brion Vibber
 */
class IndexAbstracts {
	/**
	 * Strip markup to show plaintext
	 * @param string $text
	 * @return string
	 * @access private
	 */
	function _stripMarkup( $text ) {
		global $wgContLang;

		$text = substr( $text, 0, 4096 ); // don't bother with long text...

		$text = str_replace( "'''", "", $text );
		$text = str_replace( "''", "", $text );

		$text = preg_replace( '#__[a-z0-9_]+__#i', '', $text ); // magic words

		$cleanChar = "[^|\[\]]";
		$subLink = "\[\[$cleanChar*(?:\|$cleanChar*)*\]\]";
		$pipeContents = "(?:$cleanChar|$subLink)*";
		$text = preg_replace_callback( "#
			\[\[
				($cleanChar*)
				(?:\|($pipeContents))?
				(?:\|$pipeContents)*
			\]\]
			#six", array( $this, '_stripLink' ), $text );

		$protocols = wfUrlProtocols();
		$text = preg_replace( '#\\[(?:$protocols).*? (.*?)\\]#s', '$1', $text ); // URL links
		$text = preg_replace( '#</?[a-z0-9]+.*?>#s', '', $text ); // HTML-style tags
		$text = preg_replace( '#\\{\\|.*?\\|\\}#s', '', $text ); // tables

		$text = preg_replace( '#^:.*$#m', '', $text ); // indented lines near start are usually disambigs or notices
		$text = Sanitizer::decodeCharReferences( $text );

		return trim( $text );
	}

	function _stripLink( $matches ) {
		$target = trim( $matches[1] );

		if ( isset( $matches[2] ) ) {
			$text = trim( $matches[2] );
		} else {
			$text = $target;
		}

		$title = Title::newFromText( $target );

		if ( $title ) {
			$ns = $title->getNamespace();
			if ( $title->getInterwiki() || $ns == NS_IMAGE || $ns == NS_CATEGORY ) {
				return "";
			} else {
				return $text;
			}
		} else {
			return $matches[0];
		}
	}

	/**
	 * Extract the first two sentences, if detectable, from the text.
	 * @param string $text
	 * @return string
	 * @access private
	 */
	function _extractStart( $text ) {
		$endchars = array(
			'([^\d])\.\s', '\!\s', '\?\s', // regular ASCII
			'。', // full-width ideographic full-stop
			'．', '！', '？', // double-width roman forms
			'｡', // half-width ideographic full stop
			);

		$endgroup = implode( '|', $endchars );
		$end = "(?:$endgroup)";
		$sentence = ".*?$end+";
		$firstone = "/^($sentence)/u";

		if ( preg_match( $firstone, $text, $matches ) ) {
			return $matches[1];
		} else {
			// Just return the first line
			$lines = explode( "\n", $text );

			return trim( $lines[0] );
		}
	}

	public function getExtract( $title, $chars = 50 ) {
		$rev = Revision::newFromTitle( $title );

		if ( $rev ) {
			$text = substr( $rev->getText(), 0, 16384 );

			// Ok, first note this is a TERRIBLE HACK. :D
			//
			// First, we use the system preprocessor to break down the text
			// into text, templates, extensions, and comments:
			global $wgParser;

			$wgParser->mOptions = new ParserOptions();
			$wgParser->clearState();

			$frame = $wgParser->getPreprocessor()->newFrame();
			$dom = $wgParser->preprocessToDom( $text );

			$imageArgs = array(
				'image',
				'image_skyline',
				'img',
				'Img',
			);

			// Now, we strip out everything that's not text.
			// This works with both DOM and Hash parsers, but feels fragile.
			$node = $dom->getFirstChild();
			$out = '';

			while ( $node ) {
				if ( $node->getName() == '#text' ) {
					$out .= $frame->expand( $node, PPFrame::RECOVER_ORIG );
				}
				$node = $node->getNextSibling();
			}

			// The remaining text may still contain wiki and HTML markup.
			// We'll use our shitty hand parser to strip most of those from
			// the beginning of the text.
			$stripped = $this->_stripMarkup( $out );

			// And now, we'll grab just the first sentence as text, and
			// also try to rip out a badge image.
			return $this->_extractStart( $stripped );
		}

		return '';
	}
}
