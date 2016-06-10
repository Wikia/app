<?php

/**
 * Class RecirculationContent
 * representation of what the templates need to render a piece of content
 */
class RecirculationContent implements JsonSerializable {
	private $data;

	/**
	 * RecirculationContent constructor.
	 * @param $index
	 * @param $url
	 * @param $thumbnail
	 * @param $title
	 * @param $publishDate
	 * @param $author
	 */
	public function __construct( array $properties = [] ) {
		$this->data = $properties;
	}

	public function get( $property ){
		return array_key_exists( $property, $this->data ) ? $this->data[$property] : '';
	}

	public function jsonSerialize() {
		return (object) [
			'url' => $this->get('url'),
			'index' => $this->get('index'),
			'thumbnail' => $this->get('thumbnail'),
			'title' => $this->get('title'),
			'pub_date' => $this->get('publishDate'),
			'author' => $this->get('author'),
			'source' => $this->get('source'),
		];
	}
}
