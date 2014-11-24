<?php

class ImageReviewDatabaseHelper {

	public function selectImagesForList( DatabaseMysql $oDB,
		$iState = ImageReviewStatuses::STATE_UNREVIEWED, $sOrder, $iLimit ) {

		$oResults = $oDB->query('
			SELECT pages.page_title_lower, image_review.wiki_id, image_review.page_id, image_review.state, image_review.flags, image_review.priority, image_review.last_edited
			FROM (
				SELECT image_review.wiki_id, image_review.page_id, image_review.state, image_review.flags, image_review.priority, image_review.last_edited
				FROM `image_review`
				WHERE state = ' . $iState . ' AND top_200 = false
				ORDER BY ' . $sOrder . '
				LIMIT ' . $iLimit . '
			) as image_review
			LEFT JOIN pages ON (image_review.wiki_id=pages.page_wikia_id) AND (image_review.page_id=pages.page_id) AND (pages.page_is_redirect=0)'
		);

		return $oResults;
	}
}
