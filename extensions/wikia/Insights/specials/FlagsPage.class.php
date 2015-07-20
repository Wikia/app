<?php

class FlagsPage {
	const LIMIT = 1000;

	public function isListed() {
		return false;
	}

	public function sortDescending() {
		return true;
	}

	public function isExpensive() {
		return true;
	}

	/**
	 * A wrapper for calling the querycache table
	 *
	 * @param bool $offset
	 * @param int $limit
	 * @return ResultWrapper
	 */
	public function doQuery( $offset = false, $limit = self::LIMIT ) {
		// Warning cache skipped
		return $this->reallyDoQuery( $limit, $offset );
	}

	/**
	 * Retrieves list of pages marked with flags viea flags API.
	 *
	 * @param bool $limit Only for consistency
	 * @param bool $offset Only for consistency
	 * @return array
	 */
	public function reallyDoQuery( $limit = false, $offset = false ) {

		/**
		 * Sends a request to the FlaggedPagesApiController to list of pages marked with flags
		 * with and without instances to display in the edit form.
		 * @return WikiaResponse
		 */
		$fps = F::app()->sendRequest( 'FlaggedPagesApiController', 'getFlaggedPages' )->getData()['data'];

		$result = [];
		foreach ( $fps as $pageId ) {
			$title = Title::newFromID( $pageId );
			$result[] = [
				InsightsFlagsModel::INSIGHT_TYPE,
				0,
				$title->getNamespace(),
				$title->getText()
			];
		}

		return $result;
	}

}
