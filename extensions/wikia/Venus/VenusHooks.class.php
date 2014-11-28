<?php

class VenusHooks {

	/**
	 * Add global JS variables
	 *
	 * @param array $vars global variables list
	 * @return boolean return true
	 */
	public static function onMakeGlobalVariablesScript(Array &$vars) {
		global $wgEnableVenusArticle;

		if ($wgEnableVenusArticle) {
			$vars['wgEnableVenusArticle'] = $wgEnableVenusArticle;
		}

		return true;
	}

	/**
	 * Check if infobox (div element or table which contains 'infobox' string in class attribute)
	 * exists in first article section, and extract it from this section
	 *
	 * @param Parser $parser Parser instance
	 * @param integer $section number of section in article text
	 * @param string $content reference to section content
	 * @param boolean $showEditLinks  should add edit link
	 * @return bool
	 */
	static public function onParserSectionCreate( $parser, $section, &$content, $showEditLinks ) {
		// skip if we're not parsing for venus
		if ( !F::app()->checkSkin( 'venus' ) ) {
			return true;
		}

		if ( self::isInfoboxInFirstSection( $parser, $section, $content ) ) {
			$infoboxExtractor = new InfoboxExtractor( $content );

			$dom = $infoboxExtractor->getDOMDocument();

			$nodes = $infoboxExtractor->getInfoboxNodes();
			$node = $nodes->item(0);

			if ( $node instanceof DOMElement ) {
				$body = $dom->documentElement->firstChild;

				// replace extracted infobox with a dummy element to prevent newlines from creating empty paragraphs (CON-2166)
				// <table infobox-placeholder="1"></table>
				$placeholder = $dom->createElement( 'table' );
				$placeholder->setAttribute( 'infobox-placeholder', 'true' );
				$body->insertBefore( $placeholder, $node );

				// perform a magic around infobox wrapper
				$node = $infoboxExtractor->clearInfoboxStyles( $node );
				$infoboxWrapper = $infoboxExtractor->wrapInfobox( $node, 'infoboxWrapper', 'infobox-wrapper' );
				$infoboxContainer = $infoboxExtractor->wrapInfobox( $infoboxWrapper, 'infoboxContainer', 'infobox-container' );

				// move infobox to the beginning of article content
				$infoboxExtractor->insertNode( $body, $infoboxContainer, true );

				$content = $dom->saveHTML();

				$parser->getOutput()->addModules( 'ext.wikia.venus.article.infobox' );
			}
		}

		return true;
	}

	/**
	 * Remove infobox placeholder (CON-2166)
	 *
	 * @param Parser $parser
	 * @param $text string text from the parse to replacer
	 * @return bool true, it's a hook
	 */
	static public function onParserAfterTidy(Parser $parser, &$text ) {
		$text = str_replace( '<table infobox-placeholder="true"></table>', '', $text );
		return true;
	}

	/**
	 * Check if section content is first section in article and contain 'infobox' in class attribute
	 *
	 * @param Parser $parser Parser instance
	 * @param integer $section number of section in article text
	 * @param string $content section content
	 * @return bool
	 */
	static public function isInfoboxInFirstSection( $parser, $section, $content ) {
		return $parser->mIsMainParse && $section === 0 && stripos($content, InfoboxExtractor::INFOBOX_CLASS_NAME);
	}

	/**
	 * Change the order of nodes in headlines
	 *
	 * Headline content should go first, followed by edit section link
	 *
	 * @param Skin $skin
	 * @param string $level
	 * @param string $attribs
	 * @param string $anchor
	 * @param string $html
	 * @param string $link
	 * @param boolean $legacyAnchor
	 * @param string $ret
	 * @return bool
	 */
	public static function onMakeHeadline( Skin $skin, $level, $attribs, $anchor, $html, $link, $legacyAnchor, &$ret ) {
		if ( F::app()->checkSkin( 'venus', $skin ) ) {
			$ret = "<h$level$attribs"
				. "<span class=\"mw-headline\" id=\"$anchor\">$html</span>"
				. $link
				. "</h$level>";
		}

		return true;
	}
}
