<?php

// fixme: use number_format to format large numbers with commas
// fixme: 'N' is a placeholder, replace with actual number as int
class CommunityPageSpecialWikiModel {
	private $wikiService;

	private function getWikiService() {
		return $this->wikiService;
	}

	public function __construct() {
		$this->wikiService = new WikiService();
	}

	/**
	 * Get the page count of the current wiki
	 */
	public function getPageCount( $days = 30 ) {
		return 'N';
	}

	/**
	 * Get page views of the current wiki in the last n days
	 *
	 * @param int $days
	 * @return int
	 */
	public function getWikiPageViews( $days = 30 ) {
		return 'N';
	}

	/**
	 * Get all edits for a wiki optionally filtered by the most recent n days
	 *
	 * @param int|null $days
	 * @return int
	 */
	public function getWikiEdits( $days = 30 ) {
		return 'N';
	}

	/**
	 * Get the number of editors of a wiki optionally filtered by most recent n days
	 *
	 * @param int|null $days
	 * @return int
	 */
	public function getWikiEditorCount( $days = 30 ) {
		return 'N';
	}
}
