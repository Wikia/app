<?php
/**
 * User: artur
 * Date: 03.06.13
 * Time: 11:36
 */

class JsonFormatInfoboxKeyValueNode extends JsonFormatNode {
	/**
	 * @var string
	 */
	private $key;
	/**
	 * @var JsonFormatInfoboxValueNode
	 */
	private $value;

	function __construct($key) {
		$this->key = $key;
		$this->value = new JsonFormatInfoboxValueNode();
	}

	public function setKey($key) {
		$this->key = $key;
	}

	public function getKey() {
		return $this->key;
	}

	public function getValue() {
		return $this->value;
	}

	public function addChild( $node ) {
		$this->getValue()->addChild( $node );
	}
	/**
	 * @return array Returns json serializable "arrays of arrays" representation
	 */
	public function toArray() {
		return [
			'type' => $this->getType(),
			'key' => $this->getKey(),
			'value' => $this->getValue()->toArray(),
		];
	}
}
