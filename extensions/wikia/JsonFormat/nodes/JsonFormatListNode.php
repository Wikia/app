<?php
/**
 * User: artur
 * Date: 29.05.13
 * Time: 12:14
 */

class JsonFormatListNode extends JsonFormatContainerNode {
	/**
	 * @var bool
	 */
	private $ordered;

	/**
	 * @param $ordered
	 */
	function __construct($ordered) {
		$this->ordered = $ordered;
	}

	/**
	 * @param boolean $ordered
	 */
	public function setOrdered($ordered) {
		$this->ordered = $ordered;
	}

	/**
	 * @return boolean
	 */
	public function getOrdered() {
		return $this->ordered;
	}
}
