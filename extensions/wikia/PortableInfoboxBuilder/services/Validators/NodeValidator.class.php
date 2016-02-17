<?php

namespace Wikia\PortableInfoboxBuilder\Validators;

use Wikia\PortableInfobox\Parser\Nodes\Node;
use Wikia\PortableInfobox\Parser\Nodes\NodeFactory;

abstract class NodeValidator {
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
	 * NodeValidator constructor.
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
		if ( !( $this->hasValidAttributes() && $this->hasValidChildren() ) ) {
			return false;
		}

		return true;
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
		foreach ( $this->xmlNode as $childNode ) {
			if ( !in_array( $childNode->getName(), $this->allowedChildNodes) ) {
				return false;
			}

			$validator = ValidatorBuilder::createFromNode( $childNode );
			if ( !$validator->isValid() ) {
				return false;
			}
		}
		return true;
	}
}
