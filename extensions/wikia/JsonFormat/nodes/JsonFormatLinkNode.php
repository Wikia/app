<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 21:50
 */

class JsonFormatLinkNode extends JsonFormatNode {
	/**
	 * @var string
	 */
	private $text;
	/**
	 * @var string
	 */
	private $url;

	/**
	 * @param string $text
	 * @param string $url
	 */
	function __construct( $text, $url ) {
		$this->text = $text;
		$this->url = $url;
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
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	public function toArray() {
		return [
			'type' => $this->getType(),
			'url' => $this->getUrl(),
			'text' => $this->getText(),
		];
	}
}
