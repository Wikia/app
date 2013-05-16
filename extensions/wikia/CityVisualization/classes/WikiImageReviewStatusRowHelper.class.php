<?php

class WikiImageReviewStatusRowHelper implements WikiImageRowAssigner {
	public function returnParsedWikiImageRow($row) {
		return intval($row->image_review_status);
	}
}

