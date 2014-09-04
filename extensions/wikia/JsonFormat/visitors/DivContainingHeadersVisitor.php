<?php


//namespace Wikia\JsonFormat\visitors;


class DivContainingHeadersVisitor extends DOMNodeVisitorBase {
	/**
	 * @param DOMNode $currentNode
	 * @return bool
	 */
	public function canVisit( DOMNode $currentNode ) {
		/** @var DOMElement $currentNode */

		if (DomHelper::isElement( $currentNode, 'div' ) ) {
			if( \DomHelper::hasDescendantHeader( $currentNode ) ) {
				return true;
			}

			// if this div contains tabs
			if( strpos( $currentNode->getAttribute('id'), 'flytab' ) !== false ) {
				return true;
			}

			// if any descendant divs contains tabs
			$xpath = new DOMXPath( $currentNode->ownerDocument );
			$tabDivs = $xpath->query(".//div[contains(@id, 'flytab')]", $currentNode);
			if( $tabDivs->length > 0 ) {
				return true;
			}

			return false;
		}
		return false;
	}

	/**
	 * @param DOMNode $currentNode
	 */
	public function visit( DOMNode $currentNode ) {
		/** @var DOMElement $currentNode */
		DomHelper::verifyDomElementArgument( $currentNode, "currentNode" );

		// current div contains tabs
		if( strpos( $currentNode->getAttribute('id'), 'flytab' ) !== false ) {
			$this->parseTabs( $currentNode );
			return;
		}

		$this->iterate( $currentNode->childNodes );
	}

	/**
	 * @param DOMNode $currentNode
	 */
	protected function parseTabs( DOMNode $currentNode ) {
		$xpath = new DOMXPath( $currentNode->ownerDocument );
		$tabUrls = $xpath->query( ".//@href", $currentNode );

		$htmlParser = new Wikia\JsonFormat\HtmlParser();

		foreach ( $tabUrls as $url ) {
			$article = $this->getArticleByUrl( $url );
			$title = $article->getTitle()->getText();

			// Prevent from cyclic references
			if ( \Wikia\JsonFormat\HtmlParser::$VISITED[ $title ] ) {
				continue;
			}
			\Wikia\JsonFormat\HtmlParser::$VISITED[ $title ] = true;

			$tabSection = $this->parseArticleToSection( $article, $htmlParser );

			$this->adjustLevel( $tabSection );

			$this->getJsonFormatBuilder()->add( $tabSection );
		}
	}

	protected function getArticleByUrl( $url ) {
		// Transforming url, e.g.:
		// "/wiki/Some_Title?action=render" -> "Some_Title"
		$url = preg_replace( '/^\/wiki\/(.+?)\?.*$/i', '$1', $url->value );
		$title = Title::newFromURL( $url );
		$article = Article::newFromTitle( $title, RequestContext::getMain() );
		return $article;
	}

	/**
	 * @param $article
	 * @param $htmlParser
	 * @return JsonFormatSectionNode
	 */
	protected function parseArticleToSection( $article, $htmlParser ) {
		$html = $article->getPage()->getParserOutput( \ParserOptions::newFromContext( new RequestContext() ) )->getText();
		$jsonArticle = $htmlParser->parse( $html );
		$tabSection = new JsonFormatSectionNode( 1, $article->getTitle()->getText() );
		foreach ( $jsonArticle->getChildren() as $child ) {
			$tabSection->addChild( $child );
		}
		return $tabSection;
	}

	/**
	 * From description of the task: PLA-1848
	 *
	 * Tabs should be rendered as ordinary sections with the same level as the section above.
	 * The exception is level 1 which is unique to article title.
	 *
	 * Sections inside the tabview cannot have levels lower or equal than the tabs.
	 * Such sections have to have their level increased to be one higher than the tab.
	 *
	 * This should apply to the whole tree of levels.
	 *
	 * @param $tabSection
	 */
	protected function adjustLevel( $tabSection ) {
		$level = 0;
		if ( $this->getJsonFormatBuilder()->getCurrentContainer()->getType() === 'section' ) {
			$level = $this->getJsonFormatBuilder()->getCurrentContainer()->getLevel();
		}
		if ( $level > 0 ) {
			if ( $level > 1 ) {
				$level -= 1;
			}
			$this->addLevel( $tabSection, $level );
		}
	}

	protected function addLevel( $node, $level ) {
		if( property_exists( $node, 'level' ) && method_exists( $node, 'getLevel' ) && method_exists( $node, 'setLevel' ) ) {
			$node->setLevel( $node->getLevel() + $level );
		}
		if( method_exists( $node, 'getChildren' ) ) {
			foreach( $node->getChildren() as $child ) {
				$this->addLevel( $child, $level );
			}
		}
	}
}
