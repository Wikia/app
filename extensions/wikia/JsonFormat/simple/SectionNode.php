<?php

namespace Wikia\JsonFormat\Simple;

class SectionNode {
	/**
	 * @var String
	 */
	private $name;
	/**
	 * @var String[]
	 */
	private $paragraphs;
	/**
	 * @var \Wikia\JsonFormat\Simple\ImageNode[]
	 */
	private $images;
	/**
	 * @var int
	 */
	private $level;

	/**
	 * @param String $name
	 * @param int $level
	 * @param String[] $paragraphs
	 * @param \Wikia\JsonFormat\Simple\ImageNode[] $images
	 */
	function __construct($name, $level, $paragraphs = [], $images = []) {
		$this->name = $name;
		$this->paragraphs = $paragraphs;
		$this->images = $images;
		$this->level = $level;
	}

	public function setImages($images) {
		$this->images = $images;
	}

	public function getImages() {
		return $this->images;
	}

	/**
	 * @param String $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return String
	 */
	public function getName() {
		return $this->name;
	}

	public function setParagraphs($paragraphs) {
		$this->paragraphs = $paragraphs;
	}

	public function getParagraphs() {
		return $this->paragraphs;
	}

	/**
	 * @return int
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * @param int $level
	 */
	public function setLevel($level) {
		$this->level = $level;
	}


}
