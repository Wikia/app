<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 17:31
 */

class JsonFormatImageNode extends JsonFormatNode {
	/**
	 * @var string
	 */
	private $src;

	/**
	 * @param string $src
	 */
	function __construct($src) {
		$this->src = $src;
	}

	/**
	 * @param string $src
	 */
	public function setSrc($src) {
		$this->src = $src;
	}

	/**
	 * @return string
	 */
	public function getSrc() {
		return $this->src;
	}

	/**
	 * @return array Returns json serializable "arrays of arrays" representation
	 */
	public function toArray() {
		return [
			'type' => $this->getType(),
			'src' => $this->getSrc(),
		];
	}
}
