<?php


namespace Discussions;

class FollowsFinder {

	const TABLE_THREAD_WATCHER = 'watchlist';

	const FOLLOWER_ID = "follower_id";
	const MW_THREAD_ID = "mw_thread_id";

	const COLUMNS_FOLLOWS = [
		self::FOLLOWER_ID,
		self::MW_THREAD_ID,
	];

	private $threadNameToId;

	public function __construct( $threadNameToId ) {
		$this->threadNameToId = $threadNameToId;
	}

	/**
	 * Watchlist
	 * +--------------------------+------------------+------+-----+-------------------+-------+
	 * | Field                    | Type             | Null | Key | Default           | Extra |
	 * +--------------------------+------------------+------+-----+-------------------+-------+
	 * | wl_user                  | int(10) unsigned | NO   | PRI | NULL              |       |
	 * | wl_namespace             | int(11)          | NO   | PRI | 0                 |       |
	 * | wl_title                 | varchar(255)     | NO   | PRI |                   |       |
	 * | wl_notificationtimestamp | varbinary(14)    | YES  |     | NULL              |       |
	 * | wl_wikia_addedtimestamp  | timestamp        | YES  | MUL | CURRENT_TIMESTAMP |       |
	 * +--------------------------+------------------+------+-----+-------------------+-------+
	 */
	public function findFollows() {
		$follows = [];
		$pageTitles = array_keys( $this->threadNameToId );
		$pageTitlesChunks = array_chunk($pageTitles, 100);

		$dbh = wfGetDB( DB_SLAVE );

		if (!$dbh->tableExists(self::TABLE_THREAD_WATCHER)) {
			return $follows;
		}

		foreach($pageTitlesChunks as $part) {
			$dbh = wfGetDB( DB_SLAVE );

			( new \WikiaSQL() )->SELECT_ALL()
				->FROM( self::TABLE_THREAD_WATCHER )
				->WHERE( 'wl_namespace' )
				->EQUAL_TO( NS_WIKIA_FORUM_BOARD_THREAD )
				->AND_( 'wl_title' )
				->IN( $part )
				->runLoop( $dbh, function ( &$follows, $row ) {
					$follows[] = [
						self::FOLLOWER_ID => $row->wl_user,
						self::MW_THREAD_ID => $this->threadNameToId[$row->wl_title],
					];
				} );

			$dbh->close();
		}

		return $follows;
	}

}
