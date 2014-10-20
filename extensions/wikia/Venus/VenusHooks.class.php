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
			$infobox = '';
			$dom = DOMDocument::loadHTML($content);
			$finder = new DOMXPath($dom);
			$query = "((//div|//table)[contains(translate(@class, 'INFOBOX', '" . self::INFOBOX_CLASS_NAME . "'), '" .
				self::INFOBOX_CLASS_NAME . "')])[1]";
			$nodes = $finder->query($query);
			$node = $nodes->item(0);

			if (!is_null($node)) {
				if ($node->hasAttribute('style')) {
					$node->removeAttribute('style');
				}
				$infobox = $dom->saveHTML($node);
				$node->parentNode->removeChild($node);

				$content = $dom->saveHTML();
				$infobox = Html::rawElement(
					'div',
					[ 'id' => 'infoboxContainer', 'class' => 'infobox-container' ],
					$infobox
				);
				$parser->getOutput()->setBeforeTextHTML($infobox);
				$parser->getOutput()->addModules( 'ext.wikia.venus.article.infobox' );
			}
		}

		return true;
	}

}
