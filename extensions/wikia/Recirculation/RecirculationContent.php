<?php

/**
 * Class RecirculationContent
 * representation of what the templates need to render a piece of content
 */
class RecirculationContent implements JsonSerializable {

	private $index;

	private $url;

	private $thumbnail;

	private $title;

	private $publishDate;

	private $author;

	/**
	 * RecirculationContent constructor.
	 * @param $index
	 * @param $url
	 * @param $thumbnail
	 * @param $title
	 * @param $publishDate
	 * @param $author
	 */
	public function __construct($index, $url, $thumbnail, $title, $publishDate, $author) {
		$this->index = $index;
		$this->url = $url;
		$this->thumbnail = $thumbnail;
		$this->title = $title;
		$this->publishDate = $publishDate;
		$this->author = $author;
	}

	function jsonSerialize() {
		return (object) [
			'url' => $this->url,
			'index' => $this->index,
			'thumbnail' => $this->thumbnail,
			'title' => $this->title,
			'pub_date' => $this->publishDate,
			'author' => $this->author,
		];
	}
}
