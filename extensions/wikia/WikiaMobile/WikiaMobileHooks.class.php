<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileHooks extends WikiaObject{
	const SECTION_OPENING = '<section class="articleSection">';
	const SECTION_CLOSING = '</section>';
	
	private $sectionsOpenedCount = 0;
	
	function __construct(){
		parent::__construct();
		
		//singleton
		F::setInstance( __CLASS__, $this );
	}

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
			
			if ( $this->sectionsOpenedCount > 0 ) {
				$text .= self::SECTION_CLOSING;
			}
						
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
				$this->sectionsOpenedCount++;

				//avoid closing a section if this is the first H2 as there will be
				//no open section before it
				if ( $this->sectionsOpenedCount > 1 ) {
					$ret = self::SECTION_CLOSING . $ret;
				}
			} else {
				$ret .= $closure;
			}
		}

		return true;
	}
}