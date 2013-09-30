<?php

namespace Wikia\JsonFormat\Simple;

class SimpleFormatTransformer {
	/**
	 * @var \JsonFormatContainerNode[]
	 */
	private $nodeStack;
	/**
	 * @var \JsonFormatContainerNode
	 */
	private $currentNode;
	/**
	 * @var String
	 */
	private $title;

	public function __construct( \JsonFormatRootNode $node, $title ) {
		$this->nodeStack[] = $node;
		$this->currentNode = $node;
		$this->title = $title;
	}

	public function nextSection() {
		$section = null;
		if ( $this->currentNode instanceof \JsonFormatRootNode ) {
			$section = new SectionNode( $this->title, 1 );
			$this->readParagraphs();
		}
	}

}
