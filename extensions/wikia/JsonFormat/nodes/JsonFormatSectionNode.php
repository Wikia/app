<?php
/**
 * User: artur
 * Date: 28.05.13
 * Time: 21:20
 */

class JsonFormatSectionNode extends JsonFormatContainerNode {
	/**
	 * @var int
	 */
	private $level;

	/**
	 * @var string
	 */
	private $title;

	function __construct( $level, $title) {
		$this->level = $level;
		$this->title = $title;
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

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}


	public function toArray() {
		$array = parent::toArray();
		$array['title'] = $this->getTitle();
		$array['level'] = $this->getLevel();
		return $array;
	}
}
