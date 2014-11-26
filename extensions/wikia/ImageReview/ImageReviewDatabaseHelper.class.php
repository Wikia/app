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
	 * @param  integer       $iState  A state to select
	 * @param  string        $sOrder  Sorting order
	 * @param  integer       $iLimit  SQL limit of queried images
	 * @return ResultWrapper          Query's results
	 */
	public function selectImagesForList( $sOrder,
		$iLimit = ImageReviewHelper::LIMIT_IMAGES_FROM_DB,
		$iState = ImageReviewStatuses::STATE_UNREVIEWED
	) {
		$oDB = $this->getDatawareDB( DB_SLAVE );

		$oResults = $oDB->query('
			SELECT pages.page_title_lower, image_review.wiki_id, image_review.page_id, image_review.state, image_review.flags, image_review.priority, image_review.last_edited
			FROM (
				SELECT image_review.wiki_id, image_review.page_id, image_review.state, image_review.flags, image_review.priority, image_review.last_edited
				FROM `image_review`
				WHERE state = ' . $iState . ' AND top_200 = 0
				ORDER BY ' . $sOrder . '
				LIMIT ' . $iLimit . '
			) as image_review
			LEFT JOIN pages ON (image_review.wiki_id=pages.page_wikia_id) AND (image_review.page_id=pages.page_id)'
		);

		return $oResults;
	}

	/**
	 * Query updating a state of a batch of images
	 * @param  Array         $aValues  Values to set
	 * @param  Array         $aWhere   SQL WHERE conditions
	 * @return void
	 */
	public function updateBatchImages( Array $aValues, Array $aWhere ) {
		$oDB = $this->getDatawareDB();

		$oDB->update(
			'image_review',
			$aValues,
			$aWhere,
			__METHOD__
		);

		$oDB->commit();
	}

	/**
	 * @param  int (const) $iDB  Database machine master/slave
	 * @return DatabaseMysql     Dataware database object
	 */
	private function getDatawareDB( $iDB = DB_MASTER ) {
		global $wgExternalDatawareDB;
		return wfGetDB( $iDB, [], $wgExternalDatawareDB );
	}
}
