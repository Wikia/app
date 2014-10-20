<?php

class VenusHooks {

	/**
	 * Check if infobox (div element or table which has class containing 'infobox' string)
	 * exists in first article section, and extract it from this section
	 *
	 * @param $parser Parser
	 * @param $section number of section in article text
	 * @param $content section text
	 * @param $showEditLinks should add edit link
	 * @return bool
	 */
	static public function onParserSectionCreate( $parser, $section, &$content, $showEditLinks ) {
		if ( $parser->mIsMainParse && $section == 0 && stripos($content, 'infobox') ) {
			$infoboxes = '';
			$dom = DOMDocument::loadHTML($content);
			$finder = new DOMXPath($dom);
			$nodes = $finder->query("(//div|//table)[contains(translate(@class, 'INFOBOX', 'infobox'), 'infobox')]");

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
		}

		return true;
	}

}
