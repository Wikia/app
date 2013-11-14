<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 21:27
 */

class JsonFormatTextNode extends JsonFormatNode {
	/**
	 * @var string
	 */
	private $text;

	/**
	 * @param string $text
	 */
	function __construct( $text ) {
		$this->text = trim($text);
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

	public function toArray() {
		return [
			'type' => $this->getType(),
			'text' => $this->getText(),
		];
	}
}
