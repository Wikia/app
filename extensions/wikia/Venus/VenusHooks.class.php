<?php

class VenusHooks {

	const INFOBOX_CLASS_NAME = 'infobox';

	/**
	 * Check if infobox (div element or table which has class containing 'infobox' string)
	 * exists in first article section, and extract it from this section
	 *
	 * @param Parser $parser Parser instance
	 * @param integer $section  number of section in article text
	 * @param string $content reference  to section content
	 * @param boolean $showEditLinks  should add edit link
	 * @return bool
	 */
	static public function onParserSectionCreate( $parser, $section, &$content, $showEditLinks ) {
		if ( $parser->mIsMainParse && $section == 0 && stripos($content, self::INFOBOX_CLASS_NAME) ) {
			$infoboxes = '';
			$dom = DOMDocument::loadHTML($content);
			$finder = new DOMXPath($dom);
			$query = "(//div|//table)[contains(translate(@class, 'INFOBOX', " . self::INFOBOX_CLASS_NAME . "), " .
				self::INFOBOX_CLASS_NAME . ")]";
			$nodes = $finder->query($query);

			foreach( $nodes as $node ) {
				if ($node->hasAttribute('style')) {
					$node->removeAttribute('style');
				}
				$infoboxes .= $dom->saveHTML($node);
				$node->parentNode->removeChild($node);
			}

			$content = $dom->saveHTML();
			$infoboxes = Html::rawElement(
				'div',
				[ 'id' => 'infoboxContainer', 'class' => 'infobox-container' ],
				$infoboxes
			);
			$parser->getOutput()->setBeforeTextHTML($infoboxes);
			$parser->getOutput()->addModules( 'ext.wikia.venus.article.infobox' );
		}

		return true;
	}

}
