<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 15:10
 */

class JsonFormatQuoteNode extends JsonFormatNode {
	/**
	 * @var string
	 */
	private $text;
	/**
	 * @var string
	 */
	private $author;

	/**
	 * @param $author
	 * @param $text
	 */
	function __construct($author, $text) {
		$this->author = $author;
		$this->text = $text;
	}

	/**
	 * @param $author
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * @return string
	 */
	public function getAuthor() {
		return $this->author;
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
	 * @return array Returns json serializable "arrays of arrays" representation
	 */
	public function toArray() {
		return [
			'type' => $this->getType(),
			'text' => $this->getText(),
			'author' => $this->getAuthor(),
		];
	}
}
