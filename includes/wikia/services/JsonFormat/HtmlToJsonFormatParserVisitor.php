<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 14:44
 */

/**
 * Class HtmlToJsonFormatParserVisitor
 * Traverse dom tree and builds JsonFormatRepresentation
 */
class HtmlToJsonFormatParserVisitor {
	/**
	 * @var simple_html_dom_node
	 */
	private $rootElement;

	function __construct($rootElement) {
		$this->rootElement = $rootElement;
	}

	public function run() {
		return $this->visit( $this->rootElement );
	}

	/**
	 * @param simple_html_dom_node $node
	 */
	public function visit( $node ) {

		if ( $node instanceof DOMElement ) {
			if( $node->tagName == "body" ) {
				$nodes = $this->iterate( $node->childNodes );
				$root = new JsonFormatNode('root');
				$root->setChildren( $nodes );
				return $root;
			} else {
				return $this->visitElement( $node );
			}
		} else {
			return null;
		}
	}

	/**
	 * @param DOMElement $node
	 */
	public function visitElement( DOMElement $node ) {
		$headerTags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7'];
		$paragraphTags = ['div', 'p'];
		if( in_array( $node->tagName, $headerTags ) ) {
			return $this->visitHTag( $node );
		} else if ( in_array($node->tagName, $paragraphTags) ) {
			return $this->visitP( $node );
		}
	}

	/**
	 * @param DOMElement $node
	 */
	public function visitHTag( DOMElement $node ) {
		if ( $node->tagName[0] != 'h' ) {
			throw new InvalidArgumentException( "node is not hx tag" );
		}
		if( $this->verifyFirstChildHasClass( $node, "mw-headline" ) ) {
			$text = $node->childNodes->item(0)->textContent;
			$section = new JsonFormatNode( "section", $text );
			$section->setLevel( intval( $node->tagName[1] ) );
			return $section;
		}
		$text = $node->textContent;
		return new JsonFormatNode( "text", $text );
	}

	/**
	 * @param DOMElement $node
	 */
	public function visitP( DOMElement $node ) {
		$text = $node->textContent;
		return new JsonFormatNode( "text", $text );
	}

	/**
	 * @param $nodes
	 * @return DOMNodeList
	 */
	private function iterate( DOMNodeList $nodes ) {
		$results = array();
		$lastSection = null;
		for( $i = 0; $i < $nodes->length; $i++ ) {
			$node = $nodes->item($i);
			$result = $this->visit( $node );
			if( $result != null ) {
				if ( $result->getType() == 'section' ) {
					if( $lastSection != null ) {
						if( $lastSection->getLevel() > $result->getLevel() ) {
							$lastSection->addChild( $result );
						} else {
							$results[] = $lastSection;
							$lastSection = $result;
						}
					} else {
						$lastSection = $result;
					}
				} else {
					if( $lastSection ) {
						$lastSection->addChildren($result);
					} else {
						$results[] = $result;
					}
				}
			}
		}
		if ( $lastSection ) {
			$results[] = $lastSection;
		}
		return $results;
	}

	private function verifyFirstChildHasClass( DOMElement $node, $className ) {
		if( $node->childNodes->length > 0 ) {
			$firstChild = $node->childNodes->item(0);
			$firstChildClass = $firstChild->attributes->getNamedItem('class');
			if( $firstChildClass && $firstChildClass->nodeValue == $className ) {
				return true;
			}
		}
		return false;
	}
}
