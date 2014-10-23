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
			$infoboxExtract = new InfoboxExtract( $content );

			$dom = $infoboxExtract->getDOMDocument();

			$nodes = $infoboxExtract->getInfoboxNodes();
			$node = $nodes->item(0);

			if (!is_null($node)) {
				$node = $infoboxExtract->clearInfoboxStyles( $node );
				$infoboxContainer = $infoboxExtract->wrapInfobox( $node, 'infoboxContainer', 'infobox-container' );

				$body = $dom->documentElement->firstChild;
				$infoboxExtract->insertNode($body, $infoboxContainer );

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
		return $parser->mIsMainParse && $section === 0 && stripos($content, InfoboxExtract::INFOBOX_CLASS_NAME);
	}
}
