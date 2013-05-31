<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 14:23
 */

class JsonFormatImageFigureNode extends JsonFormatNode {
	/**
	 * @var string
	 */
	private $src;
	/**
	 * @var string
	 */
	private $caption;

	function __construct($src, $caption) {
		$this->src = $src;
		$this->caption = $caption;
	}

	/**
	 * @param string $caption
	 */
	public function setCaption($caption) {
		$this->caption = $caption;
	}

	/**
	 * @return string
	 */
	public function getCaption() {
		return $this->caption;
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

	public function toArray() {
		return [
			'type'    => $this->getType(),
			'src'     => $this->getSrc(),
			'caption' => $this->getCaption(),
		];
	}
}
