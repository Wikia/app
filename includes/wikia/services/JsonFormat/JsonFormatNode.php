<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 15:01
 */

/**
 * Class JsonFormatNode
 *
 * Json representation node
 */
class JsonFormatNode {
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var string
	 */
	private $text;
	/**
	 * @var array
	 */
	private $children;

	/**
	 * @var int|null
	 */
	private $level;

	/**
	 * @param string $type
	 * @param string|null $text
	 */
	function __construct( $type, $text = null ) {
		$this->type = $type;
		$this->text = $text;
	}

	/**
	 * @param $children
	 */
	public function setChildren($children) {
		$this->children = $children;
	}

	/**
	 * @return array
	 */
	public function getChildren() {
		return $this->children;
	}

	public function addChild( JsonFormatNode $child ) {
		$this->children[] = $child;
	}

	/**
	 * @param $text
	 */
	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @param $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param int|null $level
	 */
	public function setLevel($level) {
		$this->level = $level;
	}

	/**
	 * @return int|null
	 */
	public function getLevel() {
		return $this->level;
	}

	public function toArray() {
		$resultArray = [
			'text' => $this->getText(),
			'type' => $this->getType(),
			'level' => $this->getLevel(),
		];
		if( isset( $this->children ) ) {
			foreach( $this->getChildren() as $child ) {
				$resultArray['children'][] = $child->toArray();
			}
		}
		return $resultArray;
	}
}
