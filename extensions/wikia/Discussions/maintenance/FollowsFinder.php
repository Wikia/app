<?php



namespace Discussions;

class FollowsFinder {

	const TABLE_THREAD_WATCHER = 'watchlist';

	private $dbh;
	private $threadNameToId;

	public function __construct( $dbh, $threadNameToId) {
		$this->dbh = $dbh;
		$this->threadNameToId = $threadNameToId;
	}

	public function findFollows() {
		$pageTitles = array_keys($this->threadNameToId);
		return ( new \WikiaSQL() )->SELECT_ALL()
			->FROM( self::TABLE_THREAD_WATCHER )
			->WHERE( 'wl_namespace' )
			->EQUAL_TO( NS_WIKIA_FORUM_BOARD_THREAD )
			->AND_( 'wl_title' )
			->IN( $pageTitles )
			->runLoop( $this->dbh, function ( &$follows, $row ) {

				$follows[] = [
					'follower_id' => $row->wl_user,
					'mw_thread_id' => $this->threadNameToId[$row->wl_title],
					'timestamp' => $row->wl_notificationtimestamp,
				];
			} );
	}

}
