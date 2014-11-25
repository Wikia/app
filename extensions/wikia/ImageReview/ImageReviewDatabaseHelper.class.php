<?php
/**
 * It is a class that will hold all of ImageReview queries
 * for ease of finding and managing them.
 *
 * @package ImageReview
 * @author  Adam Karmiński <adamk@wikia-inc.com>
 */

class ImageReviewDatabaseHelper {

	/**
	 * Query selecting images populating a list
	 * @param  DatabaseMysql $oDB     A Dataware DB object 
	 * @param  integer       $iState  A state to select
	 * @param  string        $sOrder  Sorting order
	 * @param  integer       $iLimit  SQL limit of queried images
	 * @return ResultWrapper          Query's results
	 */
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

	/**
	 * Query updating a state of a batch of images
	 * @param  DatabaseMysql $oDB      A Dataware DB object
	 * @param  Array         $aValues  Values to set
	 * @param  Array         $aWhere   SQL WHERE conditions
	 * @return void
	 */
	public function updateBatchImages( DatabaseMysql $oDB, Array $aValues, Array $aWhere ) {
		$oDB->update(
			'image_review',
			$aValues,
			$aWhere,
			__METHOD__
		);

		$oDB->commit();
	}
}
