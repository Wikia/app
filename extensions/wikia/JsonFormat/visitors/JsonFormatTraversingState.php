<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 17:38
 */

class JsonFormatTraversingState {
	private $jsonRoot;
	private $jsonStack = array();
	private $currentContainer;

	public function pushNode( $node ) {
		$this->currentContainer = $node;
		if ( sizeof($this->jsonStack) ) {
			$this->jsonStack[sizeof($this->jsonStack)-1]->addChild( $node );
		} else {
			$this->jsonRoot = $node;
		}
		$this->jsonStack[] = $node;
	}

	public function pushSection( JsonFormatSectionNode $section ) {
		$stackPos = 1;
		for( ; $stackPos < sizeof($this->jsonStack); $stackPos++ ) {
			$stackElement = $this->jsonStack[$stackPos];
			if( !($stackElement instanceof JsonFormatSectionNode)
				|| $stackElement->getLevel() >= $section->getLevel() ) {
				break;
			}
		}
		$this->jsonStack = array_slice($this->jsonStack, 0, $stackPos);
		$this->pushNode( $section );
	}

	public function popNode( $node ) {
		if ( $this->jsonStack[sizeof($this->jsonStack)-1] === $node ) {
			array_pop($this->jsonStack);
			$this->currentContainer = $this->jsonStack[sizeof($this->jsonStack)-1];
		}
	}

	public function appendText( $text ) {
		$children = $this->currentContainer->getChildren();
		if( sizeof( $children ) > 0  ) {
			$last = array_pop( $children );
			if( $last->getType() == 'text' ) {
				$last->setText( $last->getText() . $text );
				return;
			}
		}
		$node = new JsonFormatTextNode( $text );
		$this->currentContainer->addChild( $node );
	}

	public function setCurrentContainer($currentContainer) {
		$this->currentContainer = $currentContainer;
	}

	public function getCurrentContainer() {
		return $this->currentContainer;
	}

	public function addChildToCurrentContainer( $node ) {
		$this->currentContainer->addChild($node);
	}

	public function setJsonRoot($jsonRoot) {
		$this->jsonRoot = $jsonRoot;
	}

	public function getJsonRoot() {
		return $this->jsonRoot;
	}
}
