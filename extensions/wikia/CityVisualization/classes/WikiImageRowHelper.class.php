<?php

class WikiImageRowHelper {

	public static function parseWikiImageRow($row) {
		return new self($row);
	}
	public $name, $index, $reviewed, $review_status;

	function __construct($row) {
		$this->type = $row->image_type;
		$this->index = $row->image_index;
		$this->name = $row->image_name;
		if (!empty($row->image_reviewed)){
			$this->reviewed = $row->image_reviewed;
		}
		if (!empty($row->image_review_status)){
			$this->review_status = intval($row->image_review_status);
		}
	}
}
