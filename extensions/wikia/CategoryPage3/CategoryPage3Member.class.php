<?php

class CategoryPage3Member implements \JsonSerializable {
	/** @var string */
	private $firstChar;

	/** @var string */
	private $image;

	/** @var Title */
	private $title;

	public function __construct( Title $title, string $firstChar ) {
		$this->firstChar = $firstChar;
		$this->image = null;
		$this->title = $title;
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
		return $this->getTitle()->inNamespace( NS_CATEGORY );
	}

	public function jsonSerialize() {
		return [
			'image' => $this->image,
			'isCategory' => $this->title->inNamespace( NS_CATEGORY ),
			'title' => $this->title->getText(),
			'url' => $this->title->getLocalURL(),
		];
	}
}
