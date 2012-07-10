<?php

class WikiImageReviewStatusRowHelper implements WikiImageRowAssigner {
	public function returnParsedWikiImageRow($row) {
		return $row->image_review_status;
	}
}

