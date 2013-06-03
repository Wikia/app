<?php

/**
 * LicensedVideoSwap Helper
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapHelper extends WikiaModel {

	const STATUS_SKIP = 0;
	const STATUS_SWAP_NORM = 1;
	const STATUS_SWAP_EXACT = 2;
	/**
	 * Gets a list of videos that have not yet been swapped (e.g., no decision to keep or not keep the
	 * original video has been made)
	 *
	 * @param string $sort - The sort order for the video list (options: recent, popular, trend)
	 * @param int $limit - The number of videos to return
	 * @param int $page - Which page of video to return
	 * @return array - An array of video metadata
	 */
	public function getUnswappedVideoList ( $sort = 'popular', $limit = 10, $page = 1 ) {
		wfProfileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_SLAVE );

		// We want to make sure the video hasn't been removed, is not premium and does not exist
		// in the video_swap table
		$sqlWhere = array(
			'removed' => 0,
			'premium' => 0,
			'video_title = page_title',
			'page_wikia_props.page_id IS NULL'
		);

		// Paging options
		$sqlOptions = array(
			'LIMIT'  => $limit,
			'OFFSET' => ( ( $page - 1 ) * $limit )
		);

		// Get the right sorting
		switch ( $sort ) {
			case 'popular': $sqlOptions['ORDER BY'] = 'views_total DESC';
							break;
			case 'trend'  : $sqlOptions['ORDER BY'] = 'views_30day DESC';
							break;
			default:        $sqlOptions['ORDER BY'] = 'added_at DESC';
		}

		// Do the outer join on the video_swap table
		$joinCond = array( 'page_wikia_props' => array( 'LEFT JOIN', 'page.page_id = page_wikia_props.page_id' ) );

		// Select video info making sure to skip videos that have entries in the video_swap table
		$result = $db->select(
			array( 'video_info', 'page', 'page_wikia_props' ),
			array( 'video_title, added_at, added_by' ),
			$sqlWhere,
			__METHOD__,
			$sqlOptions,
			$joinCond
		);

		// Build the return array
		$videoList = array();
		while( $row = $db->fetchObject($result) ) {
			$videoList[] = array(
				'title' => $row->video_title,
				'addedAt' => $row->added_at,
				'addedBy' => $row->added_by,
			);
		}

		wfProfileOut( __METHOD__ );

		return $videoList;
	}

	/**
	 * get sort options
	 * @param String|$selected - Text of the currently selected sort option
	 * @return array $options
	 */
	public function getSortOption( $selected ) {
		// Set it up this way for now so mustache can consume it
		// TODO: we will use a helper function in the future. Saipetch will set this up.
		$options = array(
			array(
				'sortBy' => 'recent',
				'option' => $this->wf->Message( 'specialvideos-sort-latest' ),
				'selected' => ($selected == 'recent'),
			),
			array(
				'sortBy' => 'popular',
				'option' => $this->wf->Message( 'specialvideos-sort-most-popular' ),
				'selected' => ($selected == 'popular'),
			),
			array(
				'sortBy' => 'trend',
				'option' => $this->wf->Message( 'specialvideos-sort-trending' ),
				'selected' => ($selected == 'trend'),
			)
		);

		return $options;
	}

	/**
	 * Set the status of this file page to skipped
	 * @param int|$articleId - The ID of a video's file page
	 */
	public function setSkipStatus( $articleId ) {
		$this->updateStatus( $articleId, self::STATUS_SKIP );
	}

	/**
	 * Set the status of this file page to swapped
	 * @param int|$articleId - The ID of a video's file page
	 */
	public function setSwapStatus( $articleId ) {
		$this->updateStatus( $articleId, self::STATUS_SWAP_NORM );
	}

	/**
	 * Set the status of this file page to swapped with an exact match
	 * @param int|$articleId - The ID of a video's file page
	 */
	public function setSwapExactStatus( $articleId ) {
		$this->updateStatus( $articleId, self::STATUS_SWAP_EXACT );
	}

	/**
	 * Update the status of a file page
	 * @param int|$articleId - The ID of a video's file page
	 * @param int|$status - A status constant, see STATUS_* above
	 */
	private function updateStatus( $articleId, $status ) {
		$app = F::app();
		$dbw = $app->wf->GetDB(DB_MASTER, array());
		$dbw->replace('page_wikia_props','',
			array(
				'page_id'  =>  $articleId,
				'propname' => WPP_IMAGE_SERVING,
				'props'    => serialize($status)
			),
			__METHOD__
		);
	}
}