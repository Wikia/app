<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

abstract class Node {
	/**
	 * @var array of attribute => array of accepted values, empty array = all values
	 */
	protected $allowedAttributes = [ ];

	/**
	 * @var array string
	 */
	protected $allowedChildNodes = [ ];

	/**
	 * @var array string
	 */
	protected $requiredChildNodes = [ ];

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
		if ( !( $this->hasValidContent() && $this->hasValidAttributes() && $this->hasValidChildren() && $this->hasRequiredChildren() ) ) {
			return false;
		}

		return true;
	}

	public function hasValidContent() {
		return true;
	}

	public function hasRequiredChildren() {
		$requiredChildren = array_flip( $this->requiredChildNodes );
		foreach ( $this->xmlNode->children() as $childNode ) {
			if ( in_array( $childNode->getName(), $this->requiredChildNodes ) ) {
				unset( $requiredChildren[ $childNode->getName() ] );
			}
		}
		return empty( $requiredChildren );
	}

	public function asJsonObject() {
		$result = new \StdClass();

		foreach ( $this->xmlNode->attributes() as $attribute => $value ) {
			$result->$attribute = (string)$value;
		}

		$data = $this->getChildrenAsJsonObjects();

		if ( !empty( $data ) ) {
			$result->data = $data;
		}
		$type = $this->getType();
		if ( !empty( $type ) ) {
			$result->type = $type;
		}

		return $result;
	}

	protected function getType() {
		return $this->xmlNode->getName();
	}

	protected function hasValidAttributes() {
		foreach ( $this->xmlNode->attributes() as $attribute => $value ) {
			if ( !isset( $this->allowedAttributes[ $attribute ] )
				 || !$this->hasValidAttributeValues( $attribute, $value )
			) {
				return false;
			}
		}
		return true;
	}

	protected function hasValidAttributeValues( $attribute, $value ) {
		return empty( $this->allowedAttributes[ $attribute ] )
			   || in_array( $value, $this->allowedAttributes[ $attribute ] );
	}

	protected function hasValidChildren() {
		foreach ( $this->xmlNode->children() as $childNode ) {
			if ( !in_array( $childNode->getName(), $this->allowedChildNodes ) ) {
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
	protected function getChildrenAsJsonObjects() {
		$data = [ ];

		foreach ( $this->xmlNode->children() as $childNode ) {
			$builderNode = NodeBuilder::createFromNode( $childNode );
			$nodeasJsonObject = $builderNode->asJsonObject();

			if ( is_object( $nodeasJsonObject ) ) {
				$data[] = $nodeasJsonObject;
			} elseif ( is_array( $nodeasJsonObject ) ) {
				$data = array_merge( $data, $nodeasJsonObject );
			}
		}
		return $data;
	}
}
