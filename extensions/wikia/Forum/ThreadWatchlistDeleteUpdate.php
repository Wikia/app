<?php

/**
 * Class ThreadWatchlistDeleteUpdate removes watchlist entries for a Forum Thread when it is deleted
 * @link https://wikia-inc.atlassian.net/browse/SUS-2757
 */
class ThreadWatchlistDeleteUpdate implements DeferrableUpdate {
	/** @var Title $threadTitle */
	private $threadTitle;

	public function __construct( Title $threadTitle ) {
		$this->threadTitle = $threadTitle;
	}

	/**
	 * Perform the actual work
	 */
	function doUpdate() {
		$dbw = wfGetDB( DB_MASTER );

		$dbw->delete( 'watchlist',  [
			'wl_namespace' => [ NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_BOARD_THREAD ],
			'wl_title' => $this->threadTitle->getDBkey(),
		], __METHOD__ );
	}
}
