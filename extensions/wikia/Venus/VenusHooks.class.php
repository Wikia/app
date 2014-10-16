<?php

class VenusHooks {

	static public function onParserSectionCreate( $parser, $section, &$content, $showEditLinks ) {
		if ( $parser->mIsMainParse && $section == 0 ) {
			$infoboxes = '';
			$dom = DOMDocument::loadHTML($content);
			$finder = new DOMXPath($dom);
			$nodes = $finder->query("//*[contains(@class, 'infobox')]");

			foreach( $nodes as $node ) {
				$infoboxes .= $dom->saveHTML($node);
				$node->parentNode->removeChild($node);
			}

			$content = $dom->saveHTML();
			$infoboxes = Html::rawElement( 'div', [ 'id' => 'infoboxWrapper' ], $infoboxes );
			$parser->getOutput()->setBeforeTextHTML($infoboxes);
		}

		return true;
	}

} 