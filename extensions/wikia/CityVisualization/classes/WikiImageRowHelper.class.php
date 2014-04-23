<?php

class WikiImageRowHelper {

	public static function parseWikiImageRow($row) {
		return new self($row);
	}
	public $name, $index, $reviewed, $review_status;

	function __construct($row) {
		$this->name = $row->image_name;
		$this->index = $row->image_index;
		$this->reviewed = $row->image_reviewed;
		if (!empty($row->image_review_status)){
			$this->review_status = intval($row->image_review_status);
		}
	}
}
