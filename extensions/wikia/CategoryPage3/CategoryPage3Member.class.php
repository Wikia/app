<?php

class CategoryPage3Member {
	private $firstChar;
	private $image;
	private $title;

	public function __construct( Title $title, string $firstChar ) {
		$this->firstChar = $firstChar;
		$this->image = null;
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getFirstChar(): string {
		return $this->firstChar;
	}

	/**
	 * @return null
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param null $image
	 */
	public function setImage( $image ) {
		$this->image = $image;
	}

	/**
	 * @return Title
	 */
	public function getTitle(): Title {
		return $this->title;
	}
}
