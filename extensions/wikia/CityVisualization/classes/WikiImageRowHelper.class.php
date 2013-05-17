<?php

class WikiImageRowHelper implements WikiImageRowAssigner {
	public function returnParsedWikiImageRow($row) {
		return array(
			'image_name' => $row->image_name,
			'image_index' => $row->image_index,
			'image_reviewed' => $row->image_reviewed
		);
	}
}