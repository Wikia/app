<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 21:19
 */

abstract class JsonFormatContainerNode extends JsonFormatNode {
	/**
	 * @var array
	 */
	private $children = array();

	/**
	 * @return array
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
