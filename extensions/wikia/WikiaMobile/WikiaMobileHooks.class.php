<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileHooks extends WikiaObject{
	const SECTION_OPENING = '<section class="articleSection">';
	const SECTION_CLOSING = '</section>';

	public function onOutputPageParserOutput( &$out, $parserOutput ){
		//cleanup page output from unwanted stuff
		if ( Wikia::isWikiaMobile() ) {
			$text = $parserOutput->getText();

			//remove inline styling to avoid weird results and optimize the output size
			$text = preg_replace('/\s+(style|color|bgcolor|border|align|cellspacing|cellpadding|hpace|vspace)=(\'|")[^"\']*(\'|")/im', '', $text);

			$parserOutput->setText( $text );
		}

		return true;
	}

	public function onParserLimitReport( $parser, &$limitReport ){
		//strip out some unneeded content to lower the size of the output
		$limitReport = null;
		return true;
	}

	public function onMakeHeadline( $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, $ret ){
		if ( $skin instanceof SkinWikiaMobile ) {
			//remove bold, italics, underline and anchor tags from section headings (also optimizes output size)
			$text = preg_replace( '/<\/?(b|u|i|a|em|strong){1}(\s+[^>]*)*>/im', '', $text );

			//$link contains the section edit link, add it to the next line to put it back
			//ATM editing is not allowed in WikiaMobile
			$ret = "<h{$level} id=\"{$anchor}\"{$attribs}{$text}";

			if ( $level == 2 ) {
				//add chevron to expand the section
				$ret .= '<span class=chevron></span>';
			}

			$ret .= "</h{$level}>";
		}

		return true;
	}
}