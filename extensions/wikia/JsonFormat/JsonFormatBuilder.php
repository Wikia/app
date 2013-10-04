<?php

class JsonFormatBuilder {
	/**
	 * @var JsonFormatNode
	 */
	private $jsonRoot;
	/**
	 * @var JsonFormatNode[]
	 */
	private $jsonStack = array();
	/**
	 * @var JsonFormatNode
	 */
	private $currentContainer;

	public function pushNode( JsonFormatNode $node ) {
		$this->currentContainer = $node;
		if ( sizeof($this->jsonStack) ) {
			$this->jsonStack[sizeof($this->jsonStack)-1]->addChild( $node );
		} else {
			$this->jsonRoot = $node;
		}
		$this->jsonStack[] = $node;
	}

	public function pushInfoboxKeyValue( JsonFormatInfoboxKeyValueNode $keyValueNode ) {
		$valueNode = $keyValueNode->getValue();
		$this->currentContainer = $valueNode;
		if ( sizeof($this->jsonStack) ) {
			$this->jsonStack[sizeof($this->jsonStack)-1]->addChild( $keyValueNode );
		} else {
			throw new JsonFormatException('JsonFormatInfoboxKeyValueNode cannot be root');
		}
		$this->jsonStack[] = $valueNode;
	}

	public function popInfoboxKeyValue( JsonFormatInfoboxKeyValueNode $keyValueNode ) {
		if ( $this->jsonStack[sizeof($this->jsonStack)-1] === $keyValueNode->getValue() ) {
			array_pop($this->jsonStack);
			$this->currentContainer = $this->jsonStack[sizeof($this->jsonStack)-1];
		} else {
			var_dump($keyValueNode);
			var_dump($this->jsonStack);
			die();
		}
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
		if ( $this->jsonStack[sizeof($this->jsonStack)-1] == $node ) {
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

	public function add( $node ) {
		$this->currentContainer->addChild($node);
	}

	public function setJsonRoot($jsonRoot) {
		$this->jsonRoot = $jsonRoot;
	}

	public function getJsonRoot() {
		return $this->jsonRoot;
	}
}
