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
		if ( self::isInfoboxInFirstSection( $parser, $section, $content ) ) {
			$infoboxExtractor = new InfoboxExtractor( $content );

			$dom = $infoboxExtractor->getDOMDocument();

			$nodes = $infoboxExtractor->getInfoboxNodes();
			$node = $nodes->item(0);

			if (!is_null($node)) {
				$node = $infoboxExtractor->clearInfoboxStyles( $node );
				$infoboxWrapper = $infoboxExtractor->wrapInfobox( $node, 'infoboxWrapper', 'infobox-wrapper' );
				$infoboxContainer = $infoboxExtractor->wrapInfobox( $infoboxWrapper, 'infoboxContainer', 'infobox-container' );

				$body = $dom->documentElement->firstChild;
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
