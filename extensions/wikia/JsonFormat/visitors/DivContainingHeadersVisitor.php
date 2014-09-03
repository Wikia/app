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
			$xpath = new DOMXPath( $currentNode->ownerDocument );
			$tabUrls = $xpath->query(".//@href", $currentNode);
			$htmlParser = new Wikia\JsonFormat\HtmlParser();
			foreach( $tabUrls as $url ) {
				$url = preg_replace( '/^\/wiki\/(.+?)\?.*$/i', '$1', $url->value );
				$title = Title::newFromURL( $url );
				$article = Article::newFromTitle( $title, RequestContext::getMain() );

				if( \Wikia\JsonFormat\HtmlParser::$VISITED[ $article->getTitle()->getText() ] ) {
					continue;
				}
				\Wikia\JsonFormat\HtmlParser::$VISITED[ $article->getTitle()->getText() ] = true;

				$article->getContent();
				$html = $article->getPage()->getParserOutput( \ParserOptions::newFromContext( new RequestContext() ) )->getText();
				$jsonArticle = $htmlParser->parse( $html );

				$tabSection = new JsonFormatSectionNode( 1, $title->getText() );
				foreach( $jsonArticle->getChildren() as $child ) {
					$tabSection->addChild( $child );
				}

				$level = 0;
				if( $this->getJsonFormatBuilder()->getCurrentContainer()->getType() === 'section' ) {
					$level = $this->getJsonFormatBuilder()->getCurrentContainer()->getLevel();
				}
				if( $level > 1 ) {
					$this->addLevel( $tabSection, $level - 1 );
				}

				$this->getJsonFormatBuilder()->add( $tabSection );
			}
			return;
		}

		$this->iterate( $currentNode->childNodes );
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
