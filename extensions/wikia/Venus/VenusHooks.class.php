<?php

class VenusHooks {
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
		if ( self::isInfoboxInFirstSection( $parser, $section, $content ) ) {
			$infoboxExtractor = new InfoboxExtractor( $content );

			$dom = $infoboxExtractor->getDOMDocument();

			$nodes = $infoboxExtractor->getInfoboxNodes();
			$node = $nodes->item(0);

			if ( $node instanceof DOMElement ) {
				$body = $dom->documentElement->firstChild;

				// remove whitespace before and after the infobox node (CON-2166)
				$textAroundInfobox = '';

				if ( $node->previousSibling instanceof DOMText ) {
					$textAroundInfobox .= $node->previousSibling->textContent;
					$body->removeChild( $node->previousSibling );
				}

				if ( $node->nextSibling instanceof DOMText ) {
					$textAroundInfobox .= $node->nextSibling->textContent;

					// remove more than two new lines - otherwise they would create an empty paragraph (CON-2166)
					$textAroundInfobox = preg_replace( '#^\n{2,}#', "\n\n", $textAroundInfobox );

					// update the text node that follows the infobox (before it's extracted)
					$node->nextSibling->textContent = $textAroundInfobox;
				}

				// perform a magic around infobox wrapper
				$node = $infoboxExtractor->clearInfoboxStyles( $node );
				$infoboxWrapper = $infoboxExtractor->wrapInfobox( $node, 'infoboxWrapper', 'infobox-wrapper' );
				$infoboxContainer = $infoboxExtractor->wrapInfobox( $infoboxWrapper, 'infoboxContainer', 'infobox-container' );

				$infoboxExtractor->insertNode( $body, $infoboxContainer, true );

				$content = $dom->saveHTML();

				$parser->getOutput()->addModules( 'ext.wikia.venus.article.infobox' );
			}
		}

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
