<?php
/**
 * User: artur
 * Date: 22.05.13
 * Time: 17:20
 */

class HtmlToJsonFormatParserVisitorStateful {
	/**
	 * @var simple_html_dom_node
	 */
	private $rootElement;
	private $jsonRoot;
	private $jsonStack = array();
	private $currentContainer;

	function __construct($rootElement) {
		$this->rootElement = $rootElement;
	}

	public function run() {
		$this->visitBody( $this->rootElement );
		return $this->jsonRoot;
	}

	public function visitBody( $node ) {
		if( $node->tagName != "body" ) {
			throw new InvalidArgumentException("Node needs to be body.");
		}
		$root = new JsonFormatNode('root');
		$this->currentContainer = $root;
		$this->jsonRoot = $root;
		$this->jsonStack[] = $root;
		$this->iterate( $node->childNodes );
	}

	/**
	 * @param DOMElement $node
	 */
	public function visit( $node ) {
		if ( $node instanceof DOMElement ) {
			$this->visitElement( $node );
		} else if( $node instanceof DOMText ) {
			$this->visitText($node);
		}
	}

	/**
	 * @param DOMElement $node
	 */
	public function visitElement( DOMElement $node ) {
		$headerTags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7'];
		$paragraphTags = ['div', 'p'];
		if( in_array( $node->tagName, $headerTags ) ) {
			$this->visitHTag( $node );
		} else if( $node->tagName == 'a' ) {
			$this->visitA( $node );
		} else if ( in_array($node->tagName, $paragraphTags) ) {
			$this->visitP( $node );
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
			$stackPos = 1;
			for( ; $stackPos < sizeof($this->jsonStack); $stackPos++ ) {
				$stackElement = $this->jsonStack[$stackPos];
				if( $stackElement->getType() != 'section'
					|| $stackElement->getLevel() >= $section->getLevel() ) {
					break;
				}
			}
			$this->jsonStack = array_slice($this->jsonStack, 0, $stackPos);
			$this->currentContainer = $section;
			$this->jsonStack[] = $section;
			$this->jsonStack[$stackPos-1]->addChild($section);
		} else {
			$text = $node->textContent;
			$this->currentContainer->addChild($text);
		}
	}


	/**
	 * @param DOMElement $node
	 */
	public function visitA( DOMElement $node ) {
		$text = $node->textContent;
		$node = new JsonFormatNode( "text", $text );
		$this->currentContainer->addChild($node);
	}

	/**
	 * @param DOMElement $node
	 */
	public function visitP( DOMElement $node ) {
		/*
		$text = $node->textContent;
		$node = new JsonFormatNode( "text", $text );
		$this->currentContainer->addChild($node);
		*/
		$this->iterate( $node->childNodes );
	}

	/**
	 * @param DOMText $node
	 */
	public function visitText( DOMText $node ) {
		$text = $node->textContent;
		$node = new JsonFormatNode( "text", $text );
		$this->currentContainer->addChild($node);
	}

	/**
	 * @param $nodes
	 * @return DOMNodeList
	 */
	private function iterate( DOMNodeList $nodes ) {
		for( $i = 0; $i < $nodes->length; $i++ ) {
			$node = $nodes->item($i);
			$this->visit( $node );
		}
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
