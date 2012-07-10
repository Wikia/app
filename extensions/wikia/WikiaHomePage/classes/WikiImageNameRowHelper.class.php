<?php

class WikiImageNameRowHelper implements WikiImageRowAssigner {
	public function returnParsedWikiImageRow($row) {
		return $row->image_name;
	}
}
