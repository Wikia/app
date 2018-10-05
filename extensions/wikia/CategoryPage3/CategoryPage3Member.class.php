<?php

class CategoryPage3Member {
	/** @var bool */
	private $breakColumnAfter;

	/** @var string */
	private $firstChar;

	/** @var string */
	private $image;

	/** @var Title */
	private $title;

	public function __construct( Title $title, string $firstChar ) {
		$this->breakColumnAfter = false;
		$this->firstChar = $firstChar;
		$this->image = null;
		$this->title = $title;
	}

	public function isBreakColumnAfter(): bool {
		return $this->breakColumnAfter;
	}

	public function setBreakColumnAfter( $breakColumnAfter ) {
		$this->breakColumnAfter = $breakColumnAfter;
	}

	public function getFirstChar(): string {
		return $this->firstChar;
	}

	public function getImage() {
		return $this->image;
	}

	public function setImage( $image ) {
		$this->image = $image;
	}

	public function getTitle(): Title {
		return $this->title;
	}

	public function isSubcategory(): bool {
		return $this->getTitle()->getNamespace() === NS_CATEGORY;
	}
}
