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
	public function __construct( array $properties = [] ) {
		foreach($properties as $key => $value){
			$this->{$key} = $value;
		}
	}

	public function get( $property ){
		return isset( $this->{ $property } ) ? $this->{ $property } : '';
	}

	function jsonSerialize() {
		return (object) [
			'url' => $this->get('url'),
			'index' => $this->get('index'),
			'thumbnail' => $this->get('thumbnail'),
			'title' => $this->get('title'),
			'pub_date' => $this->get('publishDate'),
			'author' => $this->get('author'),
		];
	}
}
