<?php

abstract class JsonFormatContainerNode extends JsonFormatNode {
	/**
	 * @var JsonFormatNode[]
	 */
	private $children = array();

	/**
	 * @return JsonFormatNode[]
	 */
	public function getChildren() {
		return $this->children;
	}

	public function addChild( JsonFormatNode $child ) {
		$this->children[] = $child;
	}

	public function toArray() {
		$resultArray = [
			'type' => $this->getType(),
		];
		if( isset( $this->children ) ) {
			foreach( $this->getChildren() as $child ) {
				$resultArray['children'][] = $child->toArray();
			}
		}
		return $resultArray;
	}
}
