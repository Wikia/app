<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileHooks extends WikiaObject{
	public function onParserAfterTidy( &$parser, &$text ){
		//cleanup page output from unwanted stuff
		if ( $parser->getOptions()->getSkin() instanceof SkinWikiaMobile ) {
			//remove inline styling to avoid weird results and optimize the output size
			$text = preg_replace('/\s+(style|color|bgcolor|border|align|cellspacing|cellpadding|hspace|vspace)=(\'|")[^"\']*(\'|")/im', '', $text );
			
		}

		return true;
	}

	public function onParserLimitReport( $parser, &$limitReport ){
		//strip out some unneeded content to lower the size of the output
		if ( Wikia::isWikiaMobile() ) {
			$limitReport = null;
		}

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
				$ret .= '<span class=chev></span>';
			}

			$ret .= "</h{$level}>";
		}

		return true;
	}

	public function onLinkBegin( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ){
		if ( $skin instanceof SkinWikiaMobile && in_array( 'broken', $options ) ) {
			$ret = $text;
			return false;
		}

		return true;
	}
}
