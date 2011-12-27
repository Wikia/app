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
		if ( get_class( $this->wg->User->getSkin() ) == 'SkinWikiaMobile' ) {
			$text = $parserOutput->getText();

			//remove inline styling
			$text = preg_replace('/\s+(style|color|bgcolor|border|align|cellspacing|cellpadding|hpace|vspace)=(\'|")[^"\']*(\'|")/im', '', $text);

			//adding a section closing tag if WikiaMobileHooks::onMakeHeadline
			//leaves one open at the end of the output; for the way it works, if
			//there's a section opening in the page, there's always a closing missing,
			//no need for complex checks
			$parserOutput->setText( ( strpos( $text, self::SECTION_OPENING ) !== false ) ? $text . self::SECTION_CLOSING : $text );
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
			//keep the count across calls to this hook handler when rendering H2's
			static $countH2 = 0;

			//remove bold, italics, underline and anchor tags from section headings
			$text = preg_replace( '/<\/?(b|u|i|a|em|strong){1}(\s+[^>]*)*>/im', '', $text );

			//$link contains the section edit link, add it to the next line to put it back
			//ATM editing is not allowed in WikiaMobile
			$ret = "<h{$level} " . ( $level == 2 ? "class=collapsible-section" : "" ) . " id=\"{$anchor}\"{$attribs}{$text}";
			$closure = "</h{$level}>";

			if ( $level == 2 ) {
				//add chevron to expand the section and a section tag opening to wrap
				//the contents
				$ret .= "<span class=chevron></span>{$closure}" . self::SECTION_OPENING;

				//avoid closing a section if this is the first H2 as there will be
				//no open section before it
				if ( $countH2 > 0 ) {
					$ret = self::SECTION_CLOSING . $ret;
				}

				$countH2++;
			} else {
				$ret .= $closure;
			}
		}

		return true;
	}
}