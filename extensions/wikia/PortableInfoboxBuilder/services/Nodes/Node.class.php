<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

abstract class Node {
	/**
	 * allowed node attributes
	 * @var array of string
	 */
	protected $allowedAttributes = [ ];

	/**
	 * allowed child nodes
	 * @var array string
	 */
	protected $allowedChildNodes = [ ];

	/**
	 * @var Node
	 */
	protected $xmlNode;

	/**
	 * Node constructor.
	 * @param $node \SimpleXMLElement
	 */
	public function __construct( \SimpleXMLElement $node ) {
		$this->xmlNode = $node;
	}

	/**
	 * Return whether the node in its current state is supported by Infobox Builder
	 * @return bool
	 */
	public function isValid() {
		if ( !( $this->hasValidContent() && $this->hasValidAttributes() && $this->hasValidChildren() ) ) {
			return false;
		}

		return true;
	}

	public function hasValidContent() {
		return true;
	}

	public function asJson() {
		$result = new \StdClass();

		foreach ( $this->xmlNode->attributes() as $attribute => $value ) {
			$result->$attribute = (string)$value;
		}

		$data = $this->getChildrenAsJson();

		if(!empty($data)) {
			$result->data = $data;
		}
		$type = $this->getType();
		if(!empty($type)) {
			$result->type= $type;
		}

		return $result;
	}

	protected function getType() {
		return $this->xmlNode->getName();
	}

	protected function hasValidAttributes() {
		foreach ( $this->xmlNode->attributes() as $attribute => $value ) {
			if ( !in_array( $attribute, $this->allowedAttributes ) ) {
				return false;
			}
		}
		return true;
	}

	protected function hasValidChildren() {
		foreach ( $this->xmlNode->children() as $childNode ) {
			if ( !in_array( $childNode->getName(), $this->allowedChildNodes) ) {
				return false;
			}

			$builderNode = NodeBuilder::createFromNode( $childNode );
			if ( !$builderNode->isValid() ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return array
	 * @throws \Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException
	 */
	public function getChildrenAsJson() {
		$data = [];

		foreach ( $this->xmlNode->children() as $childNode ) {
			$builderNode = NodeBuilder::createFromNode( $childNode );
			$data[] = $builderNode->asJson();
		}
		return $data;
	}
}
