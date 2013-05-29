<?php

/**
 * LicensedVideoSwap Helper
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapHelper extends WikiaModel {

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
			'orig_title IS NULL'
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
		$joinCond = array( 'video_swap' => array( 'LEFT JOIN', 'video_title = orig_title' ) );

		// Select video info making sure to skip videos that have entries in the video_swap table
		$result = $db->select(
			array( 'video_info', 'video_swap' ),
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
	 * @return array $options
	 */
	public function getSortOption($selected) {
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

}